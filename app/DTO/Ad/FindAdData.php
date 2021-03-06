<?php

namespace App\DTO\Ad;

use Spatie\DataTransferObject\DataTransferObject;
use App\Http\Requests\Ads\AdsFindRequest;
use App\Enums\YesNo;
use App\Enums\Gender;

class FindAdData extends DataTransferObject
{

    public $sortBy;
    public $ages;
    public $animal;
    public $breeds;
    public $colors;
    public $gender;
    public $sterilization;
    public $page;
    public $city;

    public static function fromRequest(AdsFindRequest $request): self
    {
        return new self([
            'ages' => $request->get('ages'),
            'animal' => $request->get('animal'),
            'breeds' => $request->get('breeds', []),
            'colors' => $request->get('colors', []),
            'gender' => $request->get('gender', Gender::None),
            'sterilization' => $request->get('sterilization', YesNo::None),
            'sortBy' => $request->get('sortBy'),
            'page' => $request->get('page', 1),
            'city' => $request->get('city'),
        ]);
    }
}