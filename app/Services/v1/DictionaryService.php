<?php

namespace App\Services\v1;

use App\Models\Urgency;
use App\Models\BusinessType;
use App\Services\BaseService;

class DictionaryService extends BaseService
{
    public function urgency()
    {
        $urgency = Urgency::all(['id', 'name']);
        return $this->result(['list' => $urgency]);
    }

    public function businessTypes()
    {
        $businessTypes = BusinessType::all(['id', 'name']);
        return $this->result(['list' => $businessTypes]);
    }
}