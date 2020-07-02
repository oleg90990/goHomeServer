<?php

namespace App\Http\Controllers;

use App\Classes\Social\Vk;
use App\Http\Resources\UserProfileResource;
use App\Http\Requests\Social\VkSaveRequest;
use Illuminate\Http\Request;
use App\DTO\VkSaveGroupsData;

class VkController extends Controller
{
    /**
     * All of the current user's projects.
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function vkSave(VkSaveRequest $request) {
        $data = $request->only([
            'access_token',
            'email',
            'user_id',
            'expires_in',
            'https_required',
            'secret'
        ]);

        $this->user->update([
            'vk' => $data
        ]);

        return $this->successResponse(
            new UserProfileResource($this->user)
        );
    }

    public function vkGroups(Request $request, Vk $vkProvider) {
        $vk = $this->user->getVkInfo();

        if (!$vk) {
            return $this->successResponse([]);
        }

        return $this->successResponse(
            $vkProvider->getGroups($vk)
        );
    }

    public function vkStore(Request $request) {
        $data = VkSaveGroupsData::fromRequest($request);

        $this->user->vkGroups()
            ->delete();

        $this->user->vkGroups()
            ->createMany($data->groups);

        return $this->successResponse(
            new UserProfileResource($this->user)
        );
    }
}
