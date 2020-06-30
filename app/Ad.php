<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'images',
        'content',
        'age',
        'colors',
        'phone',
        'gender',
        'sterilization',
        'user_id',
        'breed_id',
        'animal_id',
        'active',
        'city_id'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the breeds for the animal.
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function animal()
    {
        return $this->hasOne('App\Animal');
    }

    public function breed()
    {
        return $this->hasOne('App\Breed');
    }


    public function colors()
    {
        return $this->belongsToMany('App\Color');
    }
}
