<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Http\Resources\UserProfileResource;
use App\DTO\User\{
    UserLoginData,
    UserRegisterData,
    UserUpdateData
};
use App\Http\Requests\User\{
    UserLoginRequest,
    UserRegisterRequest,
    UserUpdateRequest
};


class UserController extends Controller
{
    public function login(UserLoginRequest $request, UserRepository $repository)
    {
        $data = UserLoginData::fromRequest($request);

        $user = $repository->login($data);

        if (!$user) {
            return $this->errorResponse('Пользователь не найден', 403); 
        }

        return $this->successResponse([
            'access_token' => $user->createAccessToken(),
            'user' => new UserProfileResource($user)
        ]);
    }

    public function register(UserRegisterRequest $request, UserRepository $repository)
    {
        $data = UserRegisterData::fromRequest($request);

        $user = $repository->register($data);

        return $this->successResponse([
            'access_token' => $user->createAccessToken(),
            'user' => new UserProfileResource($user)
        ]);
    }

    public function update(UserUpdateRequest $request, UserRepository $repository)
    {
        $data = UserUpdateData::fromRequest($request);

        $user = $repository->update($data, $request->user());

        return $this->successResponse(
            new UserProfileResource($user)
        );
    }

    public function me(UserRepository $repository) {
        return $this->successResponse(
            new UserProfileResource($repository->current())
        );
    }
}
