<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserProfileResource;
use App\Http\Requests\{
    VkSaveRequest
};
use App\Classes\Vk;
use Illuminate\Http\Request;
use App\DTO\VkSaveGroupsData;

class SocialController extends Controller
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
        $user = $request->user();

        return $this->successResponse(
            $vkProvider->getGroups($user)
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
