<?php

namespace App\Http\Controllers\Group;

use App\Models\Group;
use App\Models\GroupPost;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Models\GroupPostImage;
use App\Http\Requests\StoreImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ImageResource;
use App\Contracts\ImageManagerContract;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ImageController;

const GROUP_POST_IMAGE_MAX_COUNT = 4;

class GroupPostImageController extends ImageController
{
    public function __construct(ImageManagerContract $imageManager)
    {
        parent::__construct();
        $this->_imageManager = $imageManager;
        $this->middleware('auth.api')->except('index');
        $this->middleware('can:update,post')->only(['store', 'setMainImage']);
    //    $this->middleware('can:update-post-mainimage,post,image')->only('setMainImage');
       // $this->middleware('can:delete,image')->only('destroy');
        // $this->_imageHelper = new ImageHelper($imageManager);
        // $this->_imageHelper->setMaxCount(GROUP_POST_IMAGE_MAX_COUNT);
    }

    public function getMaxImageCount(){
        return GROUP_POST_IMAGE_MAX_COUNT;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group, GroupPost $post)
    {
        return ImageResource::collection($post->images()->get());
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImage $request, Group $group, GroupPost $post)
    {
        $uploadFolder = "images/groups/{$group->id}/posts/{$post->id}";
        return $this->storeImage($request, $post, $uploadFolder);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroupPostImage  $groupPostImage
     * @return \Illuminate\Http\Response
     */
    public function show(GroupPostImage $groupPostImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GroupPostImage  $groupPostImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupPostImage $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupPostImage  $groupPostImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group, GroupPost $post, GroupPostImage $image)
    {
        return $this->deleteImage($post, $image);
    }

    public function setMainImage(Group $group, GroupPost $post, GroupPostImage $image)
    {
        return parent::setMainAndRespond($post, $image);
    }
}
