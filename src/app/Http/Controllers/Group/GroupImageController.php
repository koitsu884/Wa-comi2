<?php

namespace App\Http\Controllers\Group;

use App\Models\Group;
use App\Models\Image;
use App\Models\GroupImage;
use Illuminate\Http\Request;
use App\Http\Resources\ImageResource;
use App\Contracts\ImageManagerContract;
use App\Http\Controllers\ApiController;

const GROUP_IMAGE_MAX_COUNT = 4;

class GroupImageController extends ApiController
{
    private $_imageManager;
    public function __construct(ImageManagerContract $imageManager)
    {
        parent::__construct();
        $this->_imageManager = $imageManager;
        $this->middleware('auth.api')->except('index');
        $this->middleware('can:update,group')->only('store');
        $this->middleware('can:update-group-mainimage,group,image')->only('setMainImage');
        $this->middleware('can:delete,image')->only('destroy');
    }
    
    public function index(Group $group)
    {
        return ImageResource::collection($group->images()->get());
    }

    public function store(Request $request, Group $group)
    {
        $imageCount = $group -> imageCount();
        if($imageCount >= GROUP_IMAGE_MAX_COUNT){
            return $this->errorResponse('一つの投稿に添付できる画像は'. GROUP_IMAGE_MAX_COUNT . '枚までです', 400);
        }

        $rules = [
            'image' => 'required|mimes:jpg,jpeg,png,bmp|max:10000',
        ];
        $this->validate($request, $rules);

        $uploadFolder = "images/groups/{$group->id}";

        $path = $this->_imageManager->uploadImage($request->image, $uploadFolder);

        $image = $group->images()->create([
            'user_id' => $request->user()->id,
            'url' => $this->_imageManager->getImageFullUrl($path),
            'is_main' => $imageCount == 0 ? true : false,
            'path' => $path,
        ]);

        return new ImageResource($image);
    }

    public function destroy(Group $group, GroupImage $image)
    {
        $this->_imageManager->deleteImage($image->path);
        $image->delete();

        if($image->is_main && $group->imageCount() > 0){
            $altMainImage = $group->images()->first();
            $altMainImage->is_main = true;
            $altMainImage->save();
        }
        
        return $this->showMessage('deleted');
    }

    public function setMainImage(Group $group, GroupImage $image)
    {
        $currentMainImage = $group->mainImage()->first();

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
