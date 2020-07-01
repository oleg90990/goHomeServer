<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Classes\ImageManipulator;
use App\Http\Resources\CitiesResource;

class AdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'age' => $this->age,
            'phone' => $this->phone, 
            'gender' => $this->gender,
            'sterilization' => $this->sterilization,
            'user_id' => $this->user_id,
            'breed_id' => $this->breed_id,
            'animal_id' => $this->animal_id,
            'images' => array_map(function($url) {
                return ImageManipulator::getPublicUri($url);
            }, $this->images),
            'active' => $this->active,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'id' => $this->id,
            'city' => new CitiesResource($this->city),
            'city_id' => $this->city_id,
            'colors' => $this->colors()->get()
                ->map(function($color) {
                    return $color->id;
                })
        ];
    }
}
