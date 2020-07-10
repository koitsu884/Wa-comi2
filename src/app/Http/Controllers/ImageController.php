<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Requests\StoreImage;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ImageResource;
use App\Http\Controllers\ApiController;
use Illuminate\Database\Eloquent\Model;

abstract class ImageController extends ApiController
{
    protected $_imageManager;

    public function __construct()
    {
        parent::__construct();
    }

    public function getMaxImageCount(){
        return null;
    }

    public function storeImage(StoreImage $request, Model $model, $uploadFolter)
    {
        $data = $request->validated();

        $imageCount = $model -> imageCount();
        $maxCount = $this->getMaxImageCount();

        if($maxCount !== null &&  $imageCount >= $maxCount){
            return $this->errorResponse('一つの投稿に添付できる画像は'. $maxCount . '枚までです', 400);
        }

        $path = $this->_imageManager->uploadImage($data["image"], $uploadFolter);

        $image = $model->images()->create([
            'user_id' => Auth::user()->id,
            'url' => $this->_imageManager->getImageFullUrl($path),
            'is_main' => $imageCount == 0 ? true : false,
            'path' => $path,
        ]);
        return new ImageResource($image);
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
        return new ImageResource($image);
    }

    public function setMainAndRespond(Model $model, Image $image)
    {
        $currentMainImage = $model->mainImage()->first();

        if($currentMainImage){
            if($image->id === $currentMainImage->id)
                return new ImageResource($image);
            $currentMainImage->is_main = false;
            $currentMainImage->save();
        }

        $image->is_main=true;
        $image->save();
        return new ImageResource($image);
    }
}
