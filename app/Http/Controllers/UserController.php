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

        try {
            $user = $repository->login($data);
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(), 403
            ); 
        }

        return $this->successResponse([
            'access_token' => $user->createAccessToken(),
            'user' => new UserProfileResource($user)
        ]);
    }

    public function register(UserRegisterRequest $request, UserRepository $repository)
    {
        $data = UserRegisterData::fromRequest($request);

        try {
            $user = $repository->register($data);
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(), 403
            ); 
        }

        return $this->successResponse([
            'access_token' => $user->createAccessToken(),
            'user' => new UserProfileResource($user)
        ]);
    }

    public function update(UserUpdateRequest $request, UserRepository $repository)
    {
        $data = UserUpdateData::fromRequest($request);

        try {
            $user = $repository->update($data, $request->user());
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(), 403
            ); 
        }

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
