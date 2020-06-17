<?php

namespace App\Http\Controllers;

use App\Ad;
use App\User;
use Storage;
use Illuminate\Http\Request;
use App\Http\Requests\AdsRequest;
use App\DTO\CreateAdData;

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
            $this->storage = Storage::disk('public');
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
            'images' => $this->saveImagesFromBase64($data->images),
            'active' => true
        ]);

        $ad->save();

        $ad->colors()
           ->attach($data->colors);

        return $this->successResponse($ad);
    }

    private function saveImagesFromBase64(array $images) {
        $results = [];
        foreach ($images as $image) {
            $name = "photos/" . $this->user->id . "/" . uniqid() . ".jpeg";

            $result = $this
                ->storage
                ->put($name, $image);

            if ($result) {
                $results[] = $name;
            }
        }
        return $results;
    }
}
