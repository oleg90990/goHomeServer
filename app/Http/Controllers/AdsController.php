<?php

namespace App\Http\Controllers;

use App\Ad;
use App\User;
use Storage;
use Illuminate\Http\Request;
use App\Http\Requests\AdsRequest;
use App\DTO\CreateAdData;
use App\Http\Resources\AdResource;
use App\Classes\ImageManipulator;

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

    public function store(AdsRequest $request)
    {
        $data = CreateAdData::fromRequest($request);

        $ad = new Ad([
            'title' => $data->title,
            'content' => $data->content,
            'age' => $data->age,
            'phone' => $data->phone,
            'gender' => $data->gender,
            'sterilization' => $data->sterilization,
            'user_id' => $this->user->id,
            'breed_id' => $data->breed_id,
            'animal_id' => $data->animal_id,
            'images' => ImageManipulator::saveFromBase64($data->images, $this->user),
            'active' => true
        ]);

        $ad->save();

        $ad->colors()
           ->attach($data->colors);

        return $this->successResponse(
            new AdResource($ad)
        );
    }

    public function me() {
        $userAds = $this
            ->user
            ->ads()
            ->with('colors')
            ->get();

        return $this->successResponse(
            AdResource::collection($userAds)
        );
    }

    public function find() {
        $findAds = Ad::with('colors')->get();
        return $this->successResponse(
            AdResource::collection($findAds)
        );
    }
}
