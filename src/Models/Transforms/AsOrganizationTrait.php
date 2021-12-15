<?php

namespace Bamboo\ImportData\Models\Transforms;

use Carbon\Carbon;

trait AsOrganizationTrait
{
    public function getOrganizationData()
    {
        return [
            'name' => $this->store,
            'logo' => null,
            'employee_range' => null,
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
