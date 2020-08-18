<?php
namespace App\Repositories;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\DTO\User\{
    UserLoginData,
    UserRegisterData,
    UserUpdateData
};

class UserRepository
{

    /**
     * Auth by mobile and password
     *
     * @return App\User
     */
    public function login(UserLoginData $data): ?User
    {
        $auth = Auth::attempt([
            'mobile' => $data->mobile,
            'password' => $data->password
        ]);

        if (!$auth) { 
            return null;
        }

        return auth()->user();
    }

    /**
     * Register User
     *
     * @return Ad
     */
    public function register(UserRegisterData $data): ?User
    {
        return User::create([
            'password' => $data->password,
            'name' => $data->name,
            'mobile' => $data->mobile,
            'city_id' => $data->city_id
        ]);
    }

    /**
     * Update USer
     *
     * @return Ad
     */
    public function update(UserUpdateData $data, User $user): User
    {
        $update = [
            'name' => $data->name,
            'email' => $data->email,
            'city_id' => $data->city_id
        ];

        if ($data->password) {
            $update['password'] = $data->password;
        }

        $user->update($update);

        return $user;
    }

    /**
     * Update USer
     *
     * @return Ad
     */
    public function current(): ?User
    {
        return auth()->user();
    }
}