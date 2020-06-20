<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DictionariesRepository;
use App\Http\Resources\{
    AnimalResource,
    DictionaryResource,
    CitiesResource
};
use App\DTO\FindCityData;
use App\Http\Requests\{
    CityRequest
};

class DictionariesController extends Controller
{
    public function view(DictionariesRepository $repository) {
        $animals = $repository->animals();
        $colors = $repository->colors();

        return $this->successResponse([
            'animals' => AnimalResource::collection($animals),
            'colors' => DictionaryResource::collection($colors),
        ]);
    }

    public function city(CityRequest $request, DictionariesRepository $repository) {
        $data = FindCityData::fromRequest($request);

        $cities = $repository->findCities(
            $data->q,
            $data->includeRegions
        );

        return $this->successResponse(
             CitiesResource::collection($cities)
        );
    }
}
