<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Storage;
use Gumlet\ImageResize;

class ImageManipulator
{

    const PublicPath = '/storage/';

    /**
     * Get the breeds for the animal.
     */
    public static function saveForUser(int $userId, string $image)
    {
        $name = "photos/$userId/" . uniqid() . ".jpeg";
        return Storage::disk('public')->put($name, $image) ? $name : false;
    }

    public static function resize(string $base64) {
        $img = ImageResize::createFromString($base64);
        $img->resizeToWidth(800);
        return $img->getImageAsString();
    }

    /**
     * Get the breeds for the animal.
     */
    public static function saveFromBase64(array $images, User $user)
    {
        $results = [];

        foreach ($images as $image) {
            if (strpos($image, 'http') !== false) {
                $parse_url = parse_url($image);
                $results[] = str_replace(self::PublicPath, '', $parse_url['path']);
            } else {
                $string = self::resize(base64_decode($image));

                if ($name = self::saveForUser($user->id, $string)) {
                    $results[] = $name;
                }
            }
        }

        return $results;
    }

    /**
     * Get the breeds for the animal.
     */
    public static function getPublicUri(string $patch) {
        return asset(self::PublicPath . $patch);
    }
}


