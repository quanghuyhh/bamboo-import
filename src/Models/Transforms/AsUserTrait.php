<?php

namespace Bamboo\ImportData\Models\Transforms;

use Bamboo\ImportData\Helpers\Traits\ParseDateTrait;
use Illuminate\Support\Arr;

trait AsUserTrait
{
    use ParseDateTrait;

    public function getPortalUserData()
    {
        $userNames = explode(" ", $this->name);
        return [
            'first_name' => Arr::first($userNames),
            'last_name' => $userNames[1] ?? '',
            'email' => $this->email,
            'phone' => null,
            'employee_number' => null,
            'avatar' => null,
            'password' => null,
            'password_changed_at' => null,
            'active' => true,
            'confirmation_code' => null,
            'confirmed' => true,
            'last_login_at' => null,
            'last_login_ip' => null,
            'can_change_password' => true,
            'can_update_profile' => true,
            'can_upload_photo' => true,
            'remember_token' => $this->remember_token,
            'created_at' => static::parseDate($this->created_at),
            'updated_at' => static::parseDate($this->updated_at),
            'deleted_at' => static::parseDate($this->deleted_at),
        ];
    }

    public function getSalesUserData()
    {
        return Arr::only($this->getPortalUserData(), [
            'first_name',
            'last_name',
            'active',
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
    }
}
