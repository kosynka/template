<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateExecutorRequest;
use App\Services\v1\ExecutorService;
use App\Models\Executor;
use App\Models\City;
use App\Models\Order;
use App\Models\Offer;
use App\Models\Report;
use App\Models\Review;

class ExecutorController extends Controller
{
    private ExecutorService $executorService;

    public function __construct() {
        $this->executorService = new ExecutorService();
    }

    public function index()
    {
        $executors = Executor::paginate(50);
        $cities = City::all();

        return view('admin.executor', compact('executors', 'cities'));
    }

    public function details($id)
    {
        $executor = Executor::with('orders', 'offers', 'reports')->find($id);
        
        if ($executor->reports->isNotEmpty()) {
            foreach ($executor->reports as $report) {
                $report->image_path = $this->encodeJsonImages($report->image_path);
            }
        }

        return view('admin.executor_details', compact('executor'));
    }

    public function store(CreateExecutorRequest $request)
    {
        $data = $request->validated();
        $this->executorService->create($data);

        return redirect()->back();
    }

    public function delete($id)
    {
        $executor_id = Executor::find($id)->id;
        
        $orders = Order::all()->where('executor_id', $executor_id);
        $offers = Offer::all()->where('executor_id', $executor_id);
        $reports = Report::all()->where('executor_id', $executor_id);
        $reviews = Review::all()->where('executor_id', $executor_id);

        $this->detachRow($orders, $executor_id);
        $this->detachRow($offers, $executor_id);
        $this->detachRow($reports, $executor_id);
        $this->detachRow($reviews, $executor_id);
        
        Executor::find($id)->delete();
        return redirect('/admin/executor');
    }

    private static function detachRow($data, $row)
    {
        foreach ($data as $column) {
            $column->executor()->dissociate($row)->save();
        }
    }

    private function encodeJsonImages($images)
    {
        if (isset($images)) {
            return json_decode($images);
        } else {
            return null;
        }
    }
}