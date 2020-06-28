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
            'mobile',
            'password'
        ]);

        $auth = Auth::attempt($inputs);

        if (!$auth) { 
            return $this->errorResponse('Пользователь не найден', 403); 
        }

        $user = auth()->user();

        return $this->successResponse([
            'access_token' => $user->createAccessToken(),
            'user' => new UserProfileResource($user)
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->only([
            'name',
            'mobile',
            'password',
            'city_id'
        ]);

        $user = User::create(array_merge($data, [
            'password' => bcrypt($data['password'])
        ]));

        return $this->successResponse([
            'access_token' => $user->createAccessToken(),
            'user' => new UserProfileResource($user)
        ]);
    }

    public function update(UserUpdateRequest $request)
    {
        $data = $request->only([
            'name',
            'email',
            'city_id',
            'password'
        ]);

        if (isset($data['password']) && $data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $request->user()
            ->update($data);

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
