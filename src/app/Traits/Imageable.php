<?php

namespace App\Traits;

use App\Models\Image;
use App\Http\Resources\ImageResource;

trait Imageable
{
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function imageCount(){
        return $this->images()->count();
    }

    public function mainImage(){
        return $this->images()->where('is_main', true)->take(1);
    }

    public function getMainImage(){
        $image = $this->images()->where('is_main', true)->first();
        return $image ? new ImageResource($image) : null;
    }

    public function deleteAllImages(){
        $images = $this->images()->get();
        if($images){
            foreach($images as $image){
                $image->delete();
            }
        }
    }
}
