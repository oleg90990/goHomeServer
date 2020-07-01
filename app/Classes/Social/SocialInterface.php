<?php

namespace App\Classes\Social;

use App\Ad;
use App\User;

interface SocialInterface
{
    public static function access(User $user);
    public static function publish(Ad $ad, User $user);
    public static function update(Ad $ad, User $user);
    public static function delete(Ad $ad, User $user);
}