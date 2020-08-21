<?php

namespace App;

use Storage;
use Illuminate\Database\Eloquent\Model;
use App\Classes\ImageManipulator;

class AdPhoto extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'vk'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'vk' => 'array',
    ];

    public function getOriginalUrl()
    {
      return ImageManipulator::getOriginalUrl($this->path);
    }

    public function getThumbnailUrl()
    {
      return ImageManipulator::getThumbnailUrl($this->path);
    }

    public function getVkId()
    {
        return "photo" . $this->vk['owner_id'] . '_' . $this->vk['id'];
    }
}
