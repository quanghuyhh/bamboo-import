<?php

namespace Bamboo\ImportData\Models;

use Bamboo\ImportData\Models\Transforms\AsBrandTrait;

class Store extends BaseModel
{
    use AsBrandTrait;
    
    protected $fillable = [
        'store',
        'position',
    ];
}
