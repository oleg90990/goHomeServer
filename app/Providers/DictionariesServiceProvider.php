<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DictionariesServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'App\Repositories\DictionariesRepository'
        );
    }
}