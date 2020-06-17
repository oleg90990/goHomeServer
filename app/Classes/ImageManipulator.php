<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Storage;

class ImageManipulator
{
    /**
     * Get the breeds for the animal.
     */
    public static function save(string $name, string $image)
    {
        return Storage::disk('public')->put($name, $image);
    }

    /**
     * Get the breeds for the animal.
     */
    public static function saveFromBase64(array $images, User $user)
    {
        $results = [];

        foreach ($images as $image) {
            $name = "photos/" . $user->id . "/" . uniqid() . ".jpeg";

            if (self::save($name, $image)) {
                $results[] = $name;
            }
        }

        return $results;
    }

    /**
     * Get the breeds for the animal.
     */
    public static function getPublicUri(string $patch) {
        return asset('/storage/' . $patch);
    }
}


