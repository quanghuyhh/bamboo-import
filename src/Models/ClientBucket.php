<?php

namespace Bamboo\ImportData\Models;

use Bamboo\ImportData\Models\Transforms\AsDistributionListTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientBucket extends BaseModel
{
    use AsDistributionListTrait;

    protected $table = 'ct_clients_Buckets';

    protected $fillable = [
        'name',
        'store',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store', 'store');
    }
}
