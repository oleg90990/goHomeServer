<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Animal;
use App\Color;
use App\Http\Resources\{
    AnimalResource,
    DictionaryResource
};

class DictionariesController extends Controller
{
    public function view() {
        $animals = Animal::with('breeds')->get();
        $colors = Color::all();

        return $this->successResponse([
            'animals' => AnimalResource::collection($animals),
            'colors' => DictionaryResource::collection($colors),
        ]);
    }
}
