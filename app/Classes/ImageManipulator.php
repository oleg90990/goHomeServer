<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Storage;
use Gumlet\ImageResize;

class ImageManipulator
{
    /**
     * Get the breeds for the animal.
     */
    public static function saveForUser(int $userId, string $image)
    {
        $name = "photos/$userId/" . uniqid() . ".jpeg";
        return Storage::disk('public')->put($name, $image) ? $name : false;
    }

    /**
     * Get the breeds for the animal.
     */
    public static function saveFromBase64(array $images, User $user)
    {
        $results = [];

        foreach ($images as $base64Image) {
            $img = ImageResize::createFromString($base64Image);
            $img->resizeToWidth(800);
            $string = $img->getImageAsString();

            if ($name = self::saveForUser($user->id, $string)) {
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


