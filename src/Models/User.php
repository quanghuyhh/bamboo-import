<?php

namespace Bamboo\ImportData\Models;

use Bamboo\ImportData\Models\Transforms\AsUserTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends BaseModel
{
    use AsUserTrait;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'username',
        'deleted_at',
        'is_field_rep',
        'is_vmi_rep',
        'fulfillment_access',
        'store_access',
        'permissions',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(CountyName::class, 'county_id');
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'user_store_access', 'user_id', 'store_id');
    }
}
