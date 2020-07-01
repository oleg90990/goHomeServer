<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->user();

        return [ 
            'name' => 'required|min:3', 
            'email' => 'required|email|unique:users,email,' . $user->id, 
            'password' => '', 
            'c_password' => 'same:password',
            'city_id' => 'required|numeric'
        ];
    }
}
