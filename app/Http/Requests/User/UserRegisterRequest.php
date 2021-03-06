<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
        return [ 
            'name' => 'required|min:3',
            'mobile' => 'required|digits:11|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'city_id' => 'required|numeric'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'city_id.required' => 'Пожалуйста выберите город проживания',
            'mobile.unique' => 'Пользователь уже существует',
        ];
    }
}
