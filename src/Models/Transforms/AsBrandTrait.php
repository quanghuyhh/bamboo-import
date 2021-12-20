<?php

namespace Bamboo\ImportData\Models\Transforms;

trait AsBrandTrait
{
    public function getBrandData()
    {
        return [
            'name' => $this->store,
            'status' => 1,
        ];
    }

}
