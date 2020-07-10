<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use App\Models\Image;
use App\Models\PostImage;
use Illuminate\Http\Request;
use App\Http\Requests\StoreImage;
use App\Http\Resources\ImageResource;
use App\Contracts\ImageManagerContract;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ImageController;

const POST_IMAGE_MAX_COUNT = 4;

class PostImageController extends ImageController
{
    public function __construct(ImageManagerContract $imageManager)
    {
        parent::__construct();
        $this->_imageManager = $imageManager;
        $this->middleware('auth.api')->except('index');
        $this->middleware('can:update,post')->only('store');
        $this->middleware('can:update-post-mainimage,post,image')->only('setMainImage');
        $this->middleware('can:delete,image')->only('destroy');
    }

    public function getMaxImageCount(){
        return POST_IMAGE_MAX_COUNT;
    }
    
    public function index(Post $post)
    {
        return ImageResource::collection($post->images()->get());
    }

    public function store(StoreImage $request, Post $post)
    {
        $uploadFolder = "images/posts/{$post->id}";
        return $this->storeImage($request, $post, $uploadFolder);
    }

    public function destroy(Post $post, PostImage $image)
    {
        return $this->deleteImage($post, $image);
    }

    public function setMainImage(Post $post, PostImage $image)
    {
        return $this->setMainAndRespond($post, $image);
    }
}
