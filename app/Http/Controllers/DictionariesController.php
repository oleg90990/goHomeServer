<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Animal;
use App\Http\Resources\AnimalResource;

class DictionariesController extends Controller
{
    public function view() {
        $animals = Animal::with('breeds')->get();

        return $this->successResponse([
            'animals' => AnimalResource::collection($animals)
        ]);
    }
}
