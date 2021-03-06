<?php

namespace App\Observers;

use App\Models\Image;
use App\Contracts\ImageManagerContract;

class ImageObserver
{
    private $_imageManager;
    public function __construct(ImageManagerContract $imageManager)
    {
        $this->_imageManager = $imageManager;
    }
    /**
     * Handle the image "created" event.
     *
     * @param  \App\Image  $image
     * @return void
     */
    public function created(Image $image)
    {
        //
    }

    /**
     * Handle the image "updated" event.
     *
     * @param  \App\Image  $image
     * @return void
     */
    public function updated(Image $image)
    {
        //
    }

    /**
     * Handle the image "deleted" event.
     *
     * @param  \App\Image  $image
     * @return void
     */
    public function deleted(Image $image)
    {
        $this->_imageManager->deleteImage($image->path);
    }

    /**
     * Handle the image "restored" event.
     *
     * @param  \App\Image  $image
     * @return void
     */
    public function restored(Image $image)
    {
        //
    }

    /**
     * Handle the image "force deleted" event.
     *
     * @param  \App\Image  $image
     * @return void
     */
    public function forceDeleted(Image $image)
    {
        //
    }
}
