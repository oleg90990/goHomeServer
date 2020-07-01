<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdVkpost extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'owner_id'
    ];
}
