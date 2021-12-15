<?php

namespace Bamboo\ImportData\Models;

use Bamboo\ImportData\Models\Traits\GetLoadedTrait;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use GetLoadedTrait;

    protected $connection = 'remote';
}
