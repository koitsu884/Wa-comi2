<?php

namespace App\Http\Controllers\Group;

use App\Models\Group;
use App\Models\Image;
use App\Models\GroupImage;
use Illuminate\Http\Request;
use App\Http\Requests\StoreImage;
use App\Http\Resources\ImageResource;
use App\Contracts\ImageManagerContract;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ImageController;

const GROUP_IMAGE_MAX_COUNT = 4;

class GroupImageController extends ImageController
{
    public function __construct(ImageManagerContract $imageManager)
    {
        parent::__construct();
        $this->_imageManager = $imageManager;
        $this->middleware('auth.api')->except('index');
        $this->middleware('can:update,group')->only('store');
        $this->middleware('can:update-group-mainimage,group,image')->only('setMainImage');
        $this->middleware('can:delete,image')->only('destroy');
    }
    
    public function getMaxImageCount(){
        return GROUP_IMAGE_MAX_COUNT;
    }

    public function index(Group $group)
    {
        return ImageResource::collection($group->images()->get());
    }

    public function store(StoreImage $request, Group $group)
    {
        $uploadFolder = "images/groups/{$group->id}";
        return $this->storeImage($request, $group, $uploadFolder);
    }

    public function destroy(Group $group, GroupImage $image)
    {
        return $this->deleteImage($group, $image);
    }

    public function setMainImage(Group $group, GroupImage $image)
    {
        return $this->setMainAndRespond($group, $image);
    }
}
