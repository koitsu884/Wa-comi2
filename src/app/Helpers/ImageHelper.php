<?php

namespace App\Helpers;

use App\Models\Image;
use App\Traits\ApiResponser;
use App\Http\Requests\StoreImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Contracts\ImageManagerContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    private $_imageManager;
    private $_maxCount;
    public function __construct(ImageManagerContract $imageManager)
    {
        $this->_imageManager = $imageManager;
    }

    public function setMaxCount($count){
        $this->_maxCount = $count;
    }

    public function addImage(Model $model, $imageData, $uploadFolter)
    {
        $imageCount = $model -> imageCount();
        if($this->_maxCount > 0 &&  $imageCount >= $this->_maxCount){
            return $this->errorResponse('一つの投稿に添付できる画像は'. getImageMaxCount() . '枚までです', 400);
        }

        $path = $this->_imageManager->uploadImage($imageData, $uploadFolter);

        return $model->images()->create([
            'user_id' => Auth::user()->id,
            'url' => $this->_imageManager->getImageFullUrl($path),
            'is_main' => $imageCount == 0 ? true : false,
            'path' => $path,
        ]);
    }

    public function deleteImage(Model $model, Image $image)
    {
        $this->_imageManager->deleteImage($image->path);
        $image->delete();

        if($image->is_main && $model->imageCount() > 0){
            $altMainImage = $model->images()->first();
            $altMainImage->is_main = true;
            $altMainImage->save();
        }
    }
}