<?php

namespace Bamboo\ImportData\Models\Transforms;

use Bamboo\ImportData\Helpers\Traits\ParseDateTrait;
use Bamboo\ImportData\Models\Traits\GetLoadedTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait AsClientTrait
{
    use GetLoadedTrait;
    use ParseDateTrait;

    public function getClientData()
    {
        return [
            'pricing_group_id' => null,
            'license' => $this->license,
            'distribution_id' => null,
            'email' => Arr::first(static::getClientEmails($this->email)),
            'retailer_name' => $this->retailer,
            'trade_name' => $this->tradename,
            'ubi' => $this->ubi,
            'street' => $this->street_address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip,
            'phone' => $this->phone,
            'county' => optional($this->getLoadedRelation('county'))->county_name ?? '',
            'disable_client_login' => 0,
            'coordinate' => [
                'description' => null,
                'latitude' => $this->map_lat,
                'longitude' => $this->map_lng,
            ],
            'field_rep_id' => $this->field_rep_id,
            'vmi_rep_id' => $this->vmi_rep,
            'vmi_starting_date' => $this->start_date_vmi,
            'delivery_day' => $this->delivery_day,
            'departure_day' => $this->departure_date,
            'mail_day' => $this->mail_day,
            'password' => 'bamboo123456',
            'status' => $this->status,
            'created_at' => static::parseDate($this->created_at),
            'updated_at' => static::parseDate($this->updated_at),
            'is_custom_pricing' => false,
        ];
    }

    public function getClientContactsData()
    {
        $clientNames = explode(" ", $this->name);
        $emails = static::getClientEmails($this->email);

        return collect($emails)->map(
            fn($email, $key) => [
                'first_name' => Arr::first($clientNames),
                'last_name' => $clientNames[1] ?? '',
                'position' => 'unknow',
                'email' => $email,
                'phone' => $this->phone,
                'is_main_contact' => $key === 0,
                'created_at' => static::parseDate($this->created_at),
                'updated_at' => static::parseDate($this->updated_at),
            ]
        );
    }

    public function getClientEmails($email): array
    {
        return explode(",", $email);
    }

    /**
     * @param string $state
     * @return string
     */
    public function getClientState(string $state): string
    {
        return Str::upper(Str::substr($state, 0, 2));
    }
}
