<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;

class VkSaveGroupsData extends DataTransferObject
{
    public $groups;

    public static function fromRequest(Request $request): self
    {
        $groups = array_map(function($group_id) {
            return ['group_id' => $group_id];
        }, $request->all());

        return new self([
            'groups' => $groups
        ]);
    }
}