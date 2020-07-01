<?php

namespace App\Http\Controllers;

use App\Classes\Social\Vk;
use App\Http\Resources\UserProfileResource;
use App\Http\Requests\Social\VkSaveRequest;
use Illuminate\Http\Request;
use App\DTO\VkSaveGroupsData;

class VkController extends Controller
{

    public function vkSave(VkSaveRequest $request) {
        $data = $request->only([
            'access_token',
            'email',
            'user_id',
            'expires_in',
            'https_required',
            'secret'
        ]);

        $request->user()
            ->update([
                'vk' => $data
            ]);

        return $this->successResponse(
            new UserProfileResource(auth()->user())
        );
    }

    public function vkGroups(Request $request, Vk $vkProvider) {
        $vk = $request
            ->user()
            ->getVkInfo();

        if (!$vk) {
            return $this->successResponse([]);
        }

        return $this->successResponse(
            $vkProvider->getGroups($vk)
        );
    }

    public function vkStore(Request $request) {
        $data = VkSaveGroupsData::fromRequest($request);

        $user = $request->user();

        $user->vkGroups()
            ->delete();

         $user->vkGroups()
            ->createMany($data->groups);

        return $this->successResponse(
            new UserProfileResource(auth()->user())
        );
    }
}
