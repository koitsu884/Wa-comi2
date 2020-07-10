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

const GROUP_POST_IMAGE_MAX_COUNT = 4;

class GroupPostImageController extends ApiController
{
    private $_imageHelper;
    public function __construct(ImageManagerContract $imageManager)
    {
        parent::__construct();
        $this->middleware('auth.api')->except('index');
        $this->middleware('can:update,post')->only(['store', 'setMainImage']);
    //    $this->middleware('can:update-post-mainimage,post,image')->only('setMainImage');
        $this->middleware('can:delete,image')->only('destroy');
        $this->_imageHelper = new ImageHelper($imageManager);
        $this->_imageHelper->setMaxCount(GROUP_POST_IMAGE_MAX_COUNT);
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
        $data = $request->validated();

        $uploadFolder = "images/groups/{$group->id}/posts/{$post->id}";
        $image = $this->imageHelper->addImage($post, $data, $uploadFolder);

        return new ImageResource($image);
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
        $this->_imageHelper->deleteImage($post, $image);
        return new ImageResource($image);
    }
}
