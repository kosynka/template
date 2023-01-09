<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Report\IndexReportRequest;
use App\Http\Requests\Report\StoreReportRequest;
use App\Services\v1\ReportService;

class ReportController extends ApiController
{
    private $service;

    public function __construct() {
        $this->service = new ReportService();
    }

    public function index(IndexReportRequest $request)
    {
        $params = $request->validated();
        return $this->result($this->service->index($params));
    }
    
    public function storeReportBefore($id, StoreReportRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->service->storeReportBefore($id, $data));
    }

    public function storeReportAfter($id, StoreReportRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->service->storeReportAfter($id, $data));
    }
}