<?php

namespace App\DTO\User;

use Spatie\DataTransferObject\DataTransferObject;
use App\Http\Requests\User\UserLoginRequest;

class UserLoginData extends DataTransferObject
{
    public $password;
    public $mobile;

    public static function fromRequest(UserLoginRequest $request): self
    {
        return new self([
            'password' => $request->get('password'),
            'mobile' => $request->get('mobile')
        ]);
    }
}