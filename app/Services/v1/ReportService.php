<?php

namespace App\Services\v1;

use App\Models\Order;
use App\Models\Report;
use App\Services\BaseService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Presenters\v1\ReportPresenter;

class ReportService extends BaseService
{
    public function index($data)
    {
        $order = Order::find($data['order_id']);
        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }

        $user = auth('api-user')->user();
        if (!is_null($user) && $order->user_id != $user->id) {
            return $this->errFobidden('У вас нет доступа для просмотра отчетов');
        }
        $executor = auth('api-executor')->user();
        if (!is_null($executor) && $order->executor_id != $executor->id) {
            return $this->errFobidden('У вас нет доступа для просмотра отчетов');
        }

        $reports = Report::where('order_id', $order->id)
            ->whereIn('type', $data['type'])
            ->get();

        return $this->resultCollections($reports, ReportPresenter::class, 'list');
    }

    public function storeReportBefore($order_id, $data)
    {
        $order = Order::find($order_id);
        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }

        if ($order->status !== Order::STATUS_WAITING_FOR_REPORT) {
            return $this->errNotAcceptable('Недопустимый статус заказа для этого отчета');
        }

        $executor = auth('api-executor')->user();
        if (!is_null($executor) && $order->executor_id != $executor->id) {
            return $this->errFobidden('У вас нет доступа для загрузки отчета');
        }

        $data['images'] = json_encode($this->attachImages($data['images']));
        $reportData = [
            'order_id' => $order_id,
            'executor_id' => $executor->id,
            'comment' => $data['comment'],
            'image_path' => $data['images'],
            'type' => 'report_before',
        ];
        $report = Report::create($reportData);

        $order->status = Order::STATUS_AT_WORK;
        $order->save();

        (new PushNotificationService)->sendNotification($order->user->fb_token, 'Заказ №'. $order->id, 'Исполнитель приступил к работе', ['orderId' => $order->id]);

        return $this->ok('Отчет до начала работы загружен');
    }

    public function storeReportAfter($order_id, $data)
    {
        $order = Order::find($order_id);
        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }

        if ($order->status !== Order::STATUS_AT_WORK) {
            return $this->errNotAcceptable('Недопустимый статус заказа для этого отчета');
        }

        $executor = auth('api-executor')->user();
        if (!is_null($executor) && $order->executor_id != $executor->id) {
            return $this->errFobidden('У вас нет доступа для загрузки отчета');
        }

        $data['images'] = json_encode($this->attachImages($data['images']));
        $reportData = [
            'order_id' => $order_id,
            'executor_id' => $executor->id,
            'comment' => $data['comment'],
            'image_path' => $data['images'],
            'type' => 'report_after',
        ];
        $report = Report::create($reportData);

        $order->status = Order::STATUS_REPORT_SENT;
        $order->save();

        (new PushNotificationService)->sendNotification($order->user->fb_token, 'Заказ №'. $order->id, 'Исполнитель отправил отчет выполненной работы', ['orderId' => $order->id]);

        return $this->ok('Отчет после работы загружен');
    }

    private function attachImages(array $images)
    {
        $image_path = array();

        foreach($images as $image) {
            $fileName = time() . $image->getClientOriginalName();
            Storage::disk('public')->put('report/' . $fileName, File::get($image));
            $fileName = 'storage/report/' . $fileName;
            array_push($image_path, $fileName);
        }
        
        return $image_path;
    }
}