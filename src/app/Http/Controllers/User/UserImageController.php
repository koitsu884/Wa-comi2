<?php

namespace App\Http\Controllers\User;

use App\Contracts\ImageManagerContract;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Models\UserImage;
use App\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserImageController extends ApiController
{
    private $_imageManager;
    public function __construct(ImageManagerContract $imageManager)
    {
        parent::__construct();
        $this->_imageManager = $imageManager;
        $this->middleware('auth.api')->except('index');
        $this->middleware('can:create,App\Models\UserImage')->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $rules = [
            'image' => 'required|mimes:jpg,jpeg,png,bmp|max:10000',
        ];
        $this->validate($request, $rules);

        $uploadFolder = "images/users/{$user->id}";
   
        if ($user->imageCount() > 0) {
            $avatar = $user->mainImage()->first();
            $this->_imageManager->deleteImage($avatar->path);
            $avatar->delete();
        }

        $path = $this->_imageManager->uploadImage($request->image, $uploadFolder);

        $image = $user->images()->create([
            'user_id' => $request->user()->id,
            'url' => $this->_imageManager->getImageFullUrl($path),
            // 'url_thumb' => $url_thumb,
            'is_main' => true,
            'path' => $path,
        ]);

        return new ImageResource($image);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $avatar = $user->mainImage()->first();
        return $avatar ? new ImageResource($avatar) : null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $avatar = $user->getMainImage();
        if($avatar)
        {
            $avatar->delete();
        }
        return $this->showMessage('deleted');
    }
}
