<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Passport\Client as OClient; 
use Carbon\Carbon;
use App\Http\Resources\UserProfileResource;
use App\Http\Requests\{
    LoginRequest,
    RegisterRequest,
    UserUpdateRequest
};

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $inputs = $request->only([
            'email',
            'password'
        ]);

        $auth = Auth::attempt($inputs);

        if (!$auth) { 
            return $this->errorResponse('Пользователь не найден', 401); 
        }

        $user = auth()->user();

        return $this->successResponse([
            'access_token' => $user->createAccessToken(),
            'user' => new UserProfileResource($user)
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $inputs = $request->only([
            'name',
            'email',
            'password'
        ]);

        $user = User::create(array_merge($inputs, [
            'password' => bcrypt($inputs['password'])
        ]));

        return $this->successResponse([
            'access_token' => $user->createAccessToken(),
            'user' => new UserProfileResource($user)
        ]);
    }

    public function update(UserUpdateRequest $request)
    {
        $inputs = $request->only([
            'name',
            'email',
            'password'
        ]);

        if (isset($inputs['password']) && $inputs['password']) {
            $inputs['password'] = bcrypt($inputs['password']);
        } else {
            unset($inputs['password']);
        }

        $request
            ->user()
            ->update($inputs);

        return $this->successResponse(
            new UserProfileResource(auth()->user())
        );
    }

    public function me() {
        return $this->successResponse(
            new UserProfileResource(auth()->user())
        );
    }
}