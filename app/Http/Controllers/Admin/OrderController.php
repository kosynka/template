<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\OfferRepository;
use App\Services\v1\OfferService;
use App\Services\v1\OrderService;
use App\Services\v1\PushNotificationService;
use App\Models\Order;
use App\Models\Offer;
use App\Models\Report;
use App\Models\Review;
use App\Models\Executor;
use App\Models\File;

class OrderController extends Controller
{
    private OfferRepository $offerRepository;
    
    public function __construct()
    {
        $this->offerRepository = new OfferRepository();
    }

    public function index()
    {
        $orders = Order::orderBy('id', 'ASC')->paginate(25);

        foreach ($orders as $order) {
            if (isset($order['image_path'])) {
                $order['image_path'] = $this->encodeJsonImages($order['image_path']);
            }
        }

        return view('admin.order', compact('orders'));
    }

    public function details($id)
    {
        $order = Order::with('executor', 'offers', 'files')->find($id);
        $executors = Executor::all();

        if (isset($order['image_path'])) {
            $order['image_path'] = $this->encodeJsonImages($order['image_path']);
        }

        if ($order->reports->isNotEmpty()) {
            foreach ($order->reports as $report) {
                $report->image_path = $this->encodeJsonImages($report->image_path);
            }
        }
        
        return view('admin.order_details', compact('order', 'executors'));
    }

    private function encodeJsonImages($images)
    {
        if (isset($images)) {
            return json_decode($images);
        } else {
            return null;
        }
    }

    public function delete($id)
    {
        $order_id = Order::find($id)->id;
        
        $offers = Offer::all()->where('order_id', $order_id);
        $reports = Report::all()->where('order_id', $order_id);
        $reviews = Review::all()->where('order_id', $order_id);

        $this->detachRow($offers, $order_id);
        $this->detachRow($reports, $order_id);
        $this->detachRow($reviews, $order_id);
        
        Order::find($id)->delete();
        return redirect('/admin');
    }

    private static function detachRow($data, $row)
    {
        foreach ($data as $column) {
            $column->order()->dissociate($row)->save();
        }
    }

    public function acceptOffer($id)
    {
        $offer = $this->offerRepository->info($id);

        $offers = Offer::all()->where('order_id', $offer->order->id)->where('status', Offer::STATUS_CREATED)->where('executor_id', '!=', $offer->executor->id);
        foreach ($offers as $offer) {
            (new PushNotificationService)->sendNotification($offer->executor->fb_token, 'Заказ №'. $offer->order->id, 'Ваше предложение отклонено', ['orderId' => $offer->order->id]);
        }

        $this->offerRepository->update($offer, ['status' => Offer::STATUS_ACCEPTED]);

        $data = [
            'offer_id' => $offer->id,
            'executor_id' => $offer->executor_id,
            'status' => Order::STATUS_WAITING_FOR_REPORT,
        ];

        (new OrderService())->update($offer->order_id, $data);

        $this->offerRepository->declineCreated($offer->order_id);

        return redirect()->back();
    }

    public function declineOffer($id)
    {
        $offer = $this->offerRepository->info($id);
        
        $this->offerRepository->update($offer, ['status' => Offer::STATUS_DECLINED]);

        return redirect()->back();
    }

    public function updateOrder($id)
    {
        $order = Order::find($id);

        $executor_id = intval(request()['executor_id']);
        
        $order->update(['executor_id' => $executor_id, 'status' => Order::STATUS_WAITING_FOR_REPORT]);

        $offer = Offer::where('order_id', $id)->where('executor_id', $executor_id)->first();
        if (isset($offer)) {
            $this->offerRepository->update($offer, ['status' => Offer::STATUS_ACCEPTED]);
            $this->offerRepository->declineOthers($offer->order_id, $executor_id);
        }

        return redirect()->back()->with('Исполнитель успешно изменен');
    }

    public function acceptReport($id)
    {
        $order = Order::find($id);

        $order->update(['status' => Order::STATUS_APPROVED]);

        return redirect()->back();
    }

    public function declineReport($id)
    {
        $order = Order::find($id);

        $order->update(['status' => Order::STATUS_NOT_APPROVED]);

        return redirect()->back();
    }
}