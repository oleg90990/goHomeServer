<?php

namespace App\Classes;

use App\Ad;
use App\User;
use App\Enums\Social;
use App\Classes\Social\Vk;

class SocialProvider
{
    static protected $providers = [
        Social::Vk => Vk::class
    ];

    public static function publish(Ad $ad, User $user, array $providers) {
        foreach ($providers as $provider) {
            $instance = self::$providers[$provider];
            if ($instance::access($user)) {
                $instance::publish($ad, $user);
            }
        }
    }

    public static function update(Ad $ad, User $user, array $providers) {
        foreach ($providers as $provider) {
            $instance = self::$providers[$provider];
            if ($instance::access($user)) {
                $instance::update($ad, $user);
            }
        }
    }

    public static function delete(Ad $ad, User $user, array $providers) {
        foreach ($providers as $provider) {
            $instance = self::$providers[$provider];
            if ($instance::access($user)) {
                $instance::delete($ad, $user);
            }
        }
    }
}