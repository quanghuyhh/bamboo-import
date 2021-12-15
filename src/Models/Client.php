<?php

namespace Bamboo\ImportData\Models;

use Bamboo\ImportData\Models\Transforms\AsClientTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends BaseModel
{
    use AsClientTrait;

    protected $table = 'ct_clients';

    protected $fillable = [
        'name',
        'retailer',
        'email',
        'status',
        'created_at',
        'updated_at',
        'last_ordered_date',
        'tradename',
        'license',
        'ubi',
        'street_address',
        'city',
        'state',
        'zip',
        'phone',
        'county_id',
        'field_rep_id',
        'field_rep',
        'original_field_rep',
        'rep_until',
        'vmi',
        'vmi_rep',
        'start_date_vmi',
        'callteam_rep_id',
        'delivery_day',
        'mail_day',
        'price_group_id',
        'bucket_id',
        'bucket_id_accessories',
        'bucket_id_dabstract',
        'comment',
        'test_account',
        'map_lat',
        'map_lng',
        'map_formatted_address',
        'departure_date',
        'current_departure_day',
        'display_pandachunks',
        'display_ribbits',
        'pay_taxes',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(CountyName::class, 'county_id');
    }

    public function distributionList(): BelongsTo
    {
        return $this->belongsTo(ClientBucket::class, 'bucket_id');
    }

    public function salesRep()
    {
        return $this->belongsTo(User::class, 'field_rep');
    }

    public function vmiRep()
    {
        return $this->belongsTo(User::class, 'vmi_rep');
    }
}
