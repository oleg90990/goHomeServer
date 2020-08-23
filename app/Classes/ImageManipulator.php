<?php

namespace App\Classes;

use App\User;
use Image;
use Storage;

class ImageManipulator
{
    public static $templates = [
      'original' => [
        'method' => 'resize',
        'args' => [800]
      ],
      'thumbnail' => [
        'method' => 'fit',
        'args' => [600, 300]
      ]
    ];

    private static function disk() {
      return Storage::disk('photos');
    }

    public static function getOriginalUrl(string $path)
    {
      return self::disk('photos')->url($path . '/original.png');
    }

    public static function getThumbnailUrl(string $path)
    {
      return self::disk('photos')->url($path . '/thumbnail.png');
    }

    public static function fopen(string $path)
    {
      return fopen(self::disk('photos')->path($path . '/original.png'), 'rb');
    }

    private static function fromHttp(string $image)
    {
      $path = parse_url($image)['path'];
      $path = str_replace('/storage/photos/', '', $path);
      $path = str_replace('/original.png', '', $path);
      return $path;
    }

    private static function fromBase64(string $image, $name)
    {
      foreach (self::$templates as $template => $func) {
        $img = call_user_func_array([Image::make($image), $func['method']], $func['args'])->encode();

        if ($img) {
          self::disk('photos')->put($name . "/$template.png", $img);
        }
      }

      return $name;
    }

    public static function saveFromBase64(array $images, User $user)
    {
      function createName($user) {
        return "$user->id/" . uniqid();
      }

      return array_map(function($image) use ($user) {
        if (strpos($image, 'http') !== false) {
            return self::fromHttp($image);
          } else {
            return self::fromBase64($image, createName($user));
          }
      }, $images);
    }
}


