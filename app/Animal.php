<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    public $timestamps = false;

    /**
     * Get the breeds for the animal.
     */
    public function breeds()
    {
        return $this->hasMany('App\Breed');
    }
}
