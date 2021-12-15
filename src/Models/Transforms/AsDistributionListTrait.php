<?php

namespace Bamboo\ImportData\Models\Transforms;

use Carbon\Carbon;

trait AsDistributionListTrait
{
    public function getDistributionListData()
    {
        return [
            'name' => $this->name,
            'description' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
