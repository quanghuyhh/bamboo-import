<?php

namespace Bamboo\ImportData\Models;

class CountyName extends BaseModel
{
    protected $table = 'county_names';

    protected $fillable = [
        'county_name',
    ];
}
