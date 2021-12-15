<?php

namespace Bamboo\ImportData\Models\Transforms;

use Illuminate\Support\Arr;

trait AsUserTrait
{
    public function getUserData()
    {
        return [
            'first_name' => Arr::first(explode(" ", $this->name)),
            'last_name' => Arr::last(explode(" ", $this->name)),
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
