<?php

namespace App\DTO\Ad;

use Illuminate\Database\Eloquent\Model;
use Spatie\DataTransferObject\DataTransferObject;
use App\Http\Requests\Ads\AdsUpdateRequest;
use App\Enums\YesNo;

class UpdateAdData extends DataTransferObject
{
    public $id;
    public $title;
    public $content;
    public $age;
    public $gender;
    public $sterilization;
    public $colors;
    public $breed_id;
    public $animal_id;
    public $images;
    public $city_id;

    public static function fromRequest(AdsUpdateRequest $request): self
    {
        return new self([
            'id' => $request->get('id'),
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'age' => $request->get('age'),
            'gender' => $request->get('gender'),
            'sterilization' => $request->get('sterilization', YesNo::None),
            'colors' => $request->get('colors', []),
            'breed_id' => $request->get('breed_id', null),
            'animal_id' => $request->get('animal_id'),
            'images' => $request->get('images', []),
            'city_id' => $request->get('city_id')
        ]);
    }
}