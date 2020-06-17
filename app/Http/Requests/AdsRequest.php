<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Gender;
use App\Enums\YesNo;

class AdsRequest extends FormRequest
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
            'title' => 'required|min:3', 
            'age' => 'required|numeric', 
            'phone' => 'required|min:6', 
            'gender' => 'required|enum_value:' . Gender::class,
            'sterilization' => 'required|enum_value:' . YesNo::class,
            "breed_id" => 'numeric',
            "animal_id" => 'required|numeric',
        ];
    }
}
