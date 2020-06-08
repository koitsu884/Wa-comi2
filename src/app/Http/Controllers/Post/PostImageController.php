<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;

class PostImageController extends ApiController
{
    public function index(Post $post)
    {
        return ImageResource::collection($post->images());
    }

    public function store(Request $request, Post $post)
    {
        //Should upload image here and get url and url_thumb;
        $url = 'https://res.cloudinary.com/nzworks/image/upload/v1582075194/user/5e4c7712bd2b5b00173964ef/UTNZ%20Banner.jpg_1582075193920.png';
        $url_thumb = 'https://res.cloudinary.com/nzworks/image/upload/c_thumb,w_200/v1582075194/user/5e4c7712bd2b5b00173964ef/UTNZ%20Banner.jpg_1582075193920.png';

        $post->images()->create([
            'user_id' => $request->user()->id,
            'url' => $url,
            'url_thumb' => $url_thumb,
        ]);

        return ImageResource::collection($post->images());
    }

    public function destroy(Post $post, Image $image)
    {
        $this->checkUser(Auth::user(), $post);
        // Storage::delete($product->image);
        $image->delete();
        // return $this->showOne($post);
        return new ImageResource($image);
    }

    protected function checkUser(User $user, Post $post)
    {
        if ($user->id != $post->user_id) {
            throw new HttpException(422, 'The specified user is not the owner of the post');
        }
    }
}
