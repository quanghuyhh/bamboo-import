<?php

namespace Bamboo\ImportData\Models;

use Bamboo\ImportData\Models\Transforms\AsOrganizationTrait;

class Store extends BaseModel
{
    use AsOrganizationTrait;

    protected $fillable = [
        'store',
        'position',
    ];
}
