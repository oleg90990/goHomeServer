<?php

namespace App\DTO\User;

use Spatie\DataTransferObject\DataTransferObject;
use App\Http\Requests\User\UserRegisterRequest;

class UserRegisterData extends DataTransferObject
{
    public $name;
    public $mobile;
    public $password;
    public $city_id;

    public static function fromRequest(UserRegisterRequest $request): self
    {
        return new self([
            'name' => $request->get('name'),
            'mobile' => $request->get('mobile'),
            'password' => bcrypt($request->get('password')),
            'city_id' => $request->get('city_id')
        ]);
    }
}