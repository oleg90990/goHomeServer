<?php

namespace App\Http\Controllers;

use App\Ad;
use App\User;
use Storage;
use Illuminate\Http\Request;
use App\Http\Requests\{
    AdsRequest,
    AdsPublishRequest,
    AdsUpdateRequest,
    FindAdsRequest
};
use App\DTO\{
    CreateAdData,
    UpdateAdData,
    FindAdData
};
use App\Http\Resources\AdResource;
use App\Repositories\AdRepository;

class AdsController extends Controller
{
    /**
     * All of the current user's projects.
     */
    protected $user;

    /**
     * The repository for Ad model
     */
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdRepository $repository)
    {
        $this->middleware(function ($request, $next) use ($repository) {
            $this->user = auth()->user();
            $this->repository = $repository;
            return $next($request);
        });
    }

    public function store(AdsRequest $request)
    {
        $data = CreateAdData::fromRequest($request);

        $ad = $this->repository
            ->create($data, $this->user);

        return $this->successResponse(
            new AdResource($ad)
        );
    }

    public function me() {
        $ads = $this->repository
            ->getAllFromUser($this->user);

        return $this->successResponse(
            AdResource::collection($ads)
        );
    }

    public function find(FindAdsRequest $request) {
        $data = FindAdData::fromRequest($request);

        $ads = $this
            ->repository
            ->find($data);

        return $this->successResponse(
            AdResource::collection($ads)
        );
    }

    public function publish(AdsPublishRequest $request) {
        $id = $request->get('id');

        $ad = $this
            ->repository
            ->getByIdFromUser($this->user, $id);

        if (!$ad) {
            return $this->errorResponse('Объявление не найдено', 404); 
        }

        $this->repository
            ->publish($ad, $request->get('active', false));

        return $this->successResponse(
            new AdResource($ad)
        );
    }

    public function update(AdsUpdateRequest $request) {
        $data = UpdateAdData::fromRequest($request);

        $ad = $this->repository
            ->getByIdFromUser($this->user, $data->id);

        if (!$ad) {
            return $this->errorResponse('Объявление не найдено', 404); 
        }

        $ad = $this->repository
            ->update($ad, $data, $this->user);

        return $this->successResponse(
            new AdResource($ad)
        );
    }
}
