<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnimalResource extends JsonResource
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
            'name' => $this->name,
            'id' => $this->id,
            'img' => asset('/storage/' . $this->img),
            'breeds' => BreedResource::collection($this->breeds),
            'male' => $this->male,
            'female' => $this->female,
            '_none' => $this->_none,
        ];
    }
}
