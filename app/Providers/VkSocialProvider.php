<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Classes\Vk;

class VkSocialProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(Vk::class);
    }
}