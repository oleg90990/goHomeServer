<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Classes\ImageManipulator;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function photos()
    {
        return $this->hasMany(AdPhoto::class);
    }

    public function getPhotos() {
        return $this->photos;
    }

    public function getColorsIds() {
        return $this->colors()->get()
            ->map(function($color) {
                return $color->id;
            });
    }

    public function setPhotos(array $photos) {
        $patchs = ImageManipulator::saveFromBase64($photos, $this->user);

        $models = array_map(function($patch) {
            return ['patch' => $patch];
        }, $patchs);

        $this->photos()
            ->createMany($models);
    }

    public function getPublicUrlPhotos() {
        return $this->photos->map(function($photo){
            return $photo->getPublicUrl();
        });
    }

    public function setColors(array $colors) {
        $this->colors()->sync($colors);
    }
}
