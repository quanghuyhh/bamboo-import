<?php

namespace Bamboo\ImportData\Models\Transforms;

use Bamboo\ImportData\Helpers\Traits\ParseDateTrait;

trait AsCategoryTrait
{
    use ParseDateTrait;

    public function getSalesCategoryData()
    {
        return [
            'name' => $this->name,
            'description' => null,
            'status' => $this->status,
            'created_at' => static::parseDate($this->created_at),
            'updated_at' => static::parseDate($this->updated_at),
            'deleted_at' => static::parseDate($this->deleted_at),
        ];
    }
}
