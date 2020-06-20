<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Gender;
use App\Enums\YesNo;

class FindAdsRequest extends FormRequest
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
            'animal' => 'numeric',
            'gender' => 'enum_value:' . Gender::class,
            'sterilization' => 'enum_value:' . YesNo::class,
            'ages.from' => 'required|numeric',
            'ages.to' => 'required|numeric',
            'sortBy' => 'required',
            'page' => 'required|numeric',
            'city.id' => 'required'
        ];
    }
}
