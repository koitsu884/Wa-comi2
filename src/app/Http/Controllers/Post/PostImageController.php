<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use App\Models\Image;
use App\Models\PostImage;
use Illuminate\Http\Request;
use App\Http\Resources\ImageResource;
use App\Contracts\ImageManagerContract;
use App\Http\Controllers\ApiController;

const POST_IMAGE_MAX_COUNT = 4;

class PostImageController extends ApiController
{
    private $_imageManager;
    public function __construct(ImageManagerContract $imageManager)
    {
        parent::__construct();
        $this->_imageManager = $imageManager;
        $this->middleware('auth.api')->except('index');
        $this->middleware('can:update,post')->only('store');
        $this->middleware('can:update-post-mainimage,post,image')->only('setMainImage');
        $this->middleware('can:delete,image')->only('destroy');
    }
    
    public function index(Post $post)
    {
        return ImageResource::collection($post->images()->get());
    }

    public function store(Request $request, Post $post)
    {
        $imageCount = $post -> imageCount();
        if($imageCount >= POST_IMAGE_MAX_COUNT){
            return $this->errorResponse('一つの投稿に添付できる画像は'. POST_IMAGE_MAX_COUNT . '枚までです', 400);
        }

        $rules = [
            'image' => 'required|mimes:jpg,jpeg,png,bmp|max:10000',
        ];
        $this->validate($request, $rules);

        $uploadFolder = "images/posts/{$post->id}";

        $path = $this->_imageManager->uploadImage($request->image, $uploadFolder);

        $image = $post->images()->create([
            'user_id' => $request->user()->id,
            'url' => $this->_imageManager->getImageFullUrl($path),
            // 'url_thumb' => $url_thumb,
            'is_main' => $imageCount == 0 ? true : false,
            'path' => $path,
        ]);

        return new ImageResource($image);
    }

    public function destroy(Post $post, PostImage $image)
    {
        $this->_imageManager->deleteImage($image->path);
        $image->delete();

        if($image->is_main && $post->imageCount() > 0){
            $altMainImage = $post->images()->first();
            $altMainImage->is_main = true;
            $altMainImage->save();
        }
        
        return $this->showMessage('deleted');
    }

    public function setMainImage(Post $post, PostImage $image)
    {
        $currentMainImage = $post->mainImage()->first();

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
