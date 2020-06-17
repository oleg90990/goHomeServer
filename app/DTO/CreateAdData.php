<?php

namespace App\DTO;

use Illuminate\Database\Eloquent\Model;
use Spatie\DataTransferObject\DataTransferObject;
use App\Http\Requests\AdsRequest;
use App\Enums\YesNo;

class CreateAdData extends DataTransferObject
{
    public $title;
    public $content;
    public $age;
    public $phone;
    public $gender;
    public $sterilization;
    public $colors;
    public $breed_id;
    public $animal_id;
    public $images;

    public static function fromRequest(AdsRequest $request): self
    {
        return new self([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'age' => $request->get('age'),
            'phone' => $request->get('phone'),
            'gender' => $request->get('gender'),
            'sterilization' => $request->get('sterilization', YesNo::None),
            'colors' => $request->get('colors', []),
            'breed_id' => $request->get('breed_id', null),
            'animal_id' => $request->get('animal_id'),
            'images' => array_map(function($base64) {
                return base64_decode($base64);
            }, $request->get('images', []))
        ]);
    }
}