<?php

namespace App\Repositories;

use App\Models\File;

class FileRepository
{
    public function index(int $order_id)
    {
        return File::where('order_id', $order_id)->get();
    }

    public function store(array $data)
    {
        return File::create($data);
    }

    public function update(File $file, array $data)
    {
        return $file->update($data);
    }

    public function info($id)
    {
        return File::find($id);
    }

    public function delete(File $file) : void
    {
        $order->delete();
    }
}
