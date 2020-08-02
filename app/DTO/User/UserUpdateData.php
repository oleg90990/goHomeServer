<?php

namespace App\DTO\User;

use Spatie\DataTransferObject\DataTransferObject;
use App\Http\Requests\User\UserUpdateRequest;

class UserUpdateData extends DataTransferObject
{
    public $name;
    public $email;
    public $password;
    public $city_id;

    public static function fromRequest(UserUpdateRequest $request): self
    {
        return new self([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->has('password') ? bcrypt($request->get('password')) : null,
            'city_id' => $request->get('city_id')
        ]);
    }
}