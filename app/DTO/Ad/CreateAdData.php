<?php

namespace App\DTO\Ad;

use Illuminate\Database\Eloquent\Model;
use Spatie\DataTransferObject\DataTransferObject;
use App\Http\Requests\Ads\AdsCreateRequest;
use App\Enums\YesNo;

class CreateAdData extends DataTransferObject
{
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
    public $socials;

    public static function fromRequest(AdsCreateRequest $request): self
    {
        return new self([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'age' => $request->get('age'),
            'gender' => $request->get('gender'),
            'sterilization' => $request->get('sterilization', YesNo::None),
            'colors' => $request->get('colors', []),
            'breed_id' => $request->get('breed_id', null),
            'animal_id' => $request->get('animal_id'),
            'city_id' => $request->get('city_id'),
            'images' => $request->get('images', []),
            'socials' => $request->get('socials', [])
        ]);
    }
}