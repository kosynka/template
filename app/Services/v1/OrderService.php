<?php

namespace App\Services\v1;

use App\Models\Offer;
use App\Models\Order;
use App\Presenters\v1\ExecutorPresenter;
use App\Presenters\v1\OfferPresenter;
use App\Presenters\v1\OrderPresenter;
use App\Presenters\v1\FilePresenter;
use App\Repositories\OrderRepository;
use App\Repositories\FileRepository;
use App\Repositories\ReportRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class OrderService extends BaseService
{
    private OrderRepository $orderRepository;

    private ReportRepository $reportRepository;
    
    private FileRepository $fileRepository;

    private $user;

    public function __construct() {
        $this->orderRepository = new OrderRepository();
        $this->reportRepository = new ReportRepository();
        $this->fileRepository = new FileRepository();
    }

    public function defineUser()
    {
        $user = auth('api-user')->user();

        if (!isset($user)) {
            return $this->errFobidden(403, 'Требуется авторизация');
        }
        else {
            $this->user = $user;
        }
    }

    public function defineExecutor()
    {
        $executor = auth('api-executor')->user();

        if (!isset($executor)) {
            return $this->errFobidden(403, 'Требуется авторизация');
        }
        else {
            $this->user = $executor;
        }
    }

    private function checkPermissions($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }

        if ($order->executor_id != $this->user->id) {
            return $this->errNotAcceptable('В доступе отказано');
        }
    }

    public function index()
    {
        $this->defineUser();
        $user = $this->user;
        if (isset($user)) {
            $params = ['city_id' => $user->city_id];
            $orders = $this->orderRepository->onlyUserOrders($user->id, $params);
            foreach ($orders as $order) {
                if (!empty($order['image_path'])) {
                    $order['image_path'] = $this->encodeJsonImages($order['image_path']);
                }

                if (isset($data['files'])) {
                    $file_data = $this->getFiles($data, $order->id);
                    $order['files'] = $file_data;
                }
            }

            return $this->resultCollections($orders, OrderPresenter::class, 'list');
        }

        $this->defineExecutor();
        $executor = $this->user;
        if (isset($executor)) {
            $params = ['city_id' => $executor->city_id];
            $orders = $this->orderRepository->executorOrders($params);
            $orders = $orders->sortByDesc('user_id');
            foreach ($orders as $order) {
                if (!empty($order['image_path'])) {
                    $order['image_path'] = $this->encodeJsonImages($order['image_path']);
                }

                if (isset($data['files'])) {
                    $file_data = $this->getFiles($data, $order->id);
                    $order['files'] = $file_data;
                }
            }

            return $this->resultCollections($orders, OrderPresenter::class, 'list');
        }

        $orders = $this->orderRepository->index();
        foreach ($orders as $order) {
            if (!empty($order['image_path'])) {
                $order['image_path'] = $this->encodeJsonImages($order['image_path']);
            }

            if (isset($data['files'])) {
                $file_data = $this->getFiles($data, $order->id);
                $order['files'] = $file_data;
            }
        }

        return $this->resultCollections($orders, OrderPresenter::class, 'list');
    }

    public function ordersIndexByUserId(int $user_id)
    {
        $this->defineExecutor();
        $executor = $this->user;

        $params = ['city_id' => $executor->city_id];
        $params = ['user_id' => $user_id];

        $orders = $this->orderRepository->executorOrdersByUserId($params);
        $orders = $orders->sortByDesc('user_id');
        return $this->resultCollections($orders, OrderPresenter::class, 'list');
    }

    public function create(array $data)
    {
        $this->defineUser();
        $user = $this->user;
        $this->checkPhoneVerif($user);

        $data['status'] = Order::STATUS_CREATED;
        if (isset($data['images'])) {
            $data['image_path'] = json_encode($this->attachImages($data['images']));
        }

        $order = $this->orderRepository->store($data);

        if (isset($data['files'])) {
            $file_data = $this->getFiles($data, $order->id);
            $order['files'] = $file_data;
        }

        if (!empty($order['image_path'])) {
            $order['image_path'] = $this->encodeJsonImages($order['image_path']);
        }

        return $this->result([
            'order' => (new OrderPresenter($order))->list(),
        ]);
    }

    public function update(int $id, array $data)
    {
        $this->defineUser();
        $user = $this->user;
        $this->checkPhoneVerif($user);

        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }
        if ($order->user_id != $user->id) {
            return $this->errNotAcceptable('В доступе отказано');
        }

        if(isset($data['images'])) {
            $data['images'] = json_encode($this->attachImages($data['images']));
        }

        $this->orderRepository->update($order, $data);
        return $this->ok('Заявка обновлена');
    }

    public function waitReport(int $id)
    {
        $this->defineUser();
        $user = $this->user;

        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }

        if ($order->user_id != $user->id) {
            return $this->errNotAcceptable('В доступе отказано');
        }

        if ($order['status'] == Order::STATUS_OFFER_ACCEPTED) {
            $this->orderRepository->waitReport($order, ['status' => Order::STATUS_WAITING_FOR_REPORT]);
        } else {
            return $this->errNotFound('Заявка не может перейти на этот статус');
        }

        return $this->ok('Заявка ждет отчета');
    }

    public function approve(int $id)
    {
        $this->defineUser();
        $user = $this->user;
        $this->checkPhoneVerif($user);

        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }

        if ($order->user_id != $user->id) {
            return $this->errNotAcceptable('В доступе отказано');
        }

        if ($order['status'] == Order::STATUS_REPORT_SENT) {
            $this->orderRepository->approve($order, ['status' => Order::STATUS_APPROVED]);
        } else {
            return $this->errNotFound('Заявка не может перейти на этот статус');
        }

        (new PushNotificationService)->sendNotification($order->executor->fb_token, 'Заказ №'. $order->id, 'Ваш отчет принят', ['orderId' => $order->id]);

        return $this->ok('Работа одобрена');
    }

    public function notApprove(int $id)
    {
        $this->defineUser();
        $user = $this->user;
        $this->checkPhoneVerif($user);

        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }

        if ($order->user_id != $user->id) {
            return $this->errNotAcceptable('В доступе отказано');
        }

        if ($order['status'] == Order::STATUS_REPORT_SENT) {
            $this->orderRepository->notApprove($order, ['status' => Order::STATUS_NOT_APPROVED]);
        } else {
            return $this->errNotFound('Заявка не может перейти на этот статус');
        }

        (new PushNotificationService)->sendNotification($order->executor->fb_token, 'Заказ №'. $order->id, 'Ваш отчет отклонен', ['orderId' => $order->id]);

        return $this->ok('Работа Не одобрена');
    }

    public function info(int $id)
    {
        $order = $this->orderRepository->info($id);
        if(!$order) {
            return $this->errNotFound('Заявка не найдена');
        }

        if (!empty($order['image_path'])) {
            $order['image_path'] = $this->encodeJsonImages($order['image_path']);
        }

        if (isset($data['files'])) {
            $file_data = $this->getFiles($data, $order->id);
            $order['files'] = $file_data;
        }

        return $this->result([
            'order' => (new OrderPresenter($order))->list(),
        ]);
    }

    public function delete(int $id)
    {
        $this->defineUser();
        $user = $this->user;
        $this->checkPhoneVerif($user);
        
        if (!$user) {
            return $this->errFobidden('Пользователь не авторизирован');
        }

        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }
        if ($order->user_id != $user->id) {
            return $this->errNotAcceptable('В доступе отказано');
        }

        $this->orderRepository->delete($order);
        return $this->ok('Заявка удалена');
    }

    public function offers(int $id)
    {
        $user = auth()->user();
        if (!$user) {
           return $this->errFobidden('Требуется авторизация');
        }

        $order = Order::find($id);
        if (!$order) {
            return $this->errNotFound('Заявка не найдена');
        }
        if($order->user_id != $user->id)
        {
            return $this->errNotAcceptable('В доступе отказано');
        }

        return $this->resultCollections($order->offers, OfferPresenter::class, 'forOrder');
    }

    public function userOrders(array $statuses)
    {
        $this->defineUser();
        $user = $this->user;

        $orders = $this->orderRepository->userOrders($user->id, $statuses);
        foreach ($orders as $order) {
            if (!empty($order['image_path'])) {
                $order['image_path'] = $this->encodeJsonImages($order['image_path']);
            }
        }
        return $this->resultCollections($orders, OrderPresenter::class, 'list');
    }

    private function getFiles(array $data, int $order_id)
    {
        $files = $this->attachFiles($data['files']);
        $file_data = array();
        
        foreach ($files as $file) {
            $store_file['order_id'] = $order_id;
            $store_file['file_path'] = $file;
            $file = $this->fileRepository->store($store_file);
            array_push($file_data, $file);
        }

        return $file_data;
    }

    private function attachFiles(array $files)
    {
        $file_path = array();

        foreach($files as $file) {
            $fileName = time() . $file->getClientOriginalName();
            Storage::disk('public')->put('file/' . $fileName, File::get($file));
            $fileName = 'storage/file/' . $fileName;
            array_push($file_path, $fileName);
        }
        
        return $file_path;
    }

    private function attachImages(array $images)
    {
        $image_path = array();

        foreach($images as $image) {
            $fileName = time() . $image->getClientOriginalName();
            Storage::disk('public')->put('order/' . $fileName, File::get($image));
            $fileName = 'storage/order/' . $fileName;
            array_push($image_path, $fileName);
        }
        
        return $image_path;
    }

    private function encodeJsonImages($images)
    {
        if (isset($images)) {
            $images = json_decode($images);
            foreach ($images as $image) {
                $image = url($image);
                array_push($images, $image);
                array_shift($images);
            }

            return $images;
        } else {
            return null;
        }
    }

    private function checkPhoneVerif($user)
    {
        if (!$user->phone_verified_at) {
            return $this->errFobidden('Вы не верифицировали телефон');
        }
    }
}
