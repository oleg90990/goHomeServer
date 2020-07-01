<?php

namespace App\Http\Requests\Ads;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Gender;
use App\Enums\YesNo;
use App\Enums\Social;

class AdsUpdateRequest extends FormRequest
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
            'id' => 'required|numeric',
            'title' => 'required|min:3',
            'age' => 'required|numeric',
            'gender' => 'required|enum_value:' . Gender::class,
            'sterilization' => 'required|enum_value:' . YesNo::class,
            'breed_id' => 'required|numeric',
            'animal_id' => 'required|numeric',
            'socials.*' => 'enum_value:' . Social::class,
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
            'title.required' => 'Пожалуйста заполните заголовок',
            'phone.required' => 'Пожалуйста заполните телефон',
        ];
    }
}
