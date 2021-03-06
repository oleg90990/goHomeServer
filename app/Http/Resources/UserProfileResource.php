<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CitiesResource;

class UserProfileResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'city' => new CitiesResource($this->city),
            'vk' => $this->vk ? true : false,
            'vkGroups' => $this->getVkGroupsIds()
        ];
    }
}
