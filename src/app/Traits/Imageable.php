<?php

namespace App\Traits;

use App\Models\Image;

trait Imageable
{
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function imageCount(){
        return $this->images()->count();
    }

    //    public function mainImage {

    //    }
}
