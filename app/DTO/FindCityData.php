<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use App\Http\Requests\CityRequest;

class FindCityData extends DataTransferObject
{

    public $q;
    public $includeRegions;

    public static function fromRequest(CityRequest $request): self
    {
        return new self([
            'q' => $request->get('q') ?? '',
            'includeRegions' => $request->get('regions', false)
        ]);
    }
}