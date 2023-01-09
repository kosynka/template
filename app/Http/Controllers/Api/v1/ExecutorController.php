<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Executor\CreateExecutorRequest;
use App\Http\Requests\Executor\UpdateExecutorRequest;
use App\Http\Requests\User\UpdateTokenRequest;
use App\Services\v1\ExecutorService;

class ExecutorController extends ApiController
{
    private ExecutorService $executorService;

    public function __construct() {
        $this->executorService = new ExecutorService();
    }

    public function create(CreateExecutorRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->executorService->create($data));
    }

    public function update(UpdateExecutorRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->executorService->update($data));
    }

    public function info(int $id)
    {
        return $this->result($this->executorService->info($id));
    }

    public function offers()
    {
        return $this->result($this->executorService->offers());
    }

    public function updateToken(UpdateTokenRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->executorService->updateToken($this->authUser(), $data['fb_token']));
    }
}
