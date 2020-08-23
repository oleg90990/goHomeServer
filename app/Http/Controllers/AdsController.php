<?php

namespace App\Http\Controllers;

use App\Ad;
use App\User;
use Storage;
use Illuminate\Http\Request;
use App\Http\Requests\Ads\{
    AdsCreateRequest,
    AdsUpdateRequest,
    AdsPublishRequest,
    AdsFindRequest
};
use App\DTO\Ad\{
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

    public function store(AdsCreateRequest $request, AdRepository $repository)
    {
        $data = CreateAdData::fromRequest($request);

        $ad = $repository
            ->create($data, $this->user);

        return $this->successResponse(
            new AdResource($ad)
        );
    }

    public function me(AdRepository $repository) {
        $ads = $repository
            ->getAllFromUser($this->user);

        return $this->successResponse(
            AdResource::collection($ads)
        );
    }

    public function post(AdRepository $repository, string $id) {
        $post = $repository->getPost($id);

        if (!$post) {
          return $this->errorResponse('Пост не найден', 404); 
        }

        return $this->successResponse(
          new AdResource($post)
        );
    }

    public function find(AdsFindRequest $request, AdRepository $repository) {
        $data = FindAdData::fromRequest($request);
        $ads = $repository->find($data);
        return $this->successResponse([
           'items' => AdResource::collection($ads),
           'lastPage' => $ads->lastPage(),
           'currentPage' => $ads->currentPage()
        ]);
    }

    public function publish(AdsPublishRequest $request, AdRepository $repository) {
        $id = $request->get('id');

        $ad = $repository
            ->getByIdFromUser($this->user, $id);

        if (!$ad) {
            return $this->errorResponse('Объявление не найдено', 404); 
        }

        $repository
            ->publish($ad, $this->user, $request->get('active', false));

        return $this->successResponse(
            new AdResource($ad)
        );
    }

    public function update(AdsUpdateRequest $request, AdRepository $repository) {
        $data = UpdateAdData::fromRequest($request);

        $ad = $repository
            ->getByIdFromUser($this->user, $data->id);

        if (!$ad) {
            return $this->errorResponse('Объявление не найдено', 404); 
        }

        $ad = $repository
            ->update($ad, $data, $this->user);

        return $this->successResponse(
            new AdResource($ad)
        );
    }
}
