<?php

namespace App\Http\Controllers\User;

use App\Contracts\ImageManagerContract;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Models\UserImage;
use App\User;
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
        // $this->middleware('can:create,App\Models\UserImage')->only('store');
        $this->middleware('can:delete,image')->only('destroy');
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
            'image' => 'required|image',
        ];
        $this->validate($request, $rules);

        $uploadPath = "images/users/{$user->id}";
        $fileName = 'avatar.' .  $request->image->getClientOriginalExtension();
        Log::debug($request);
        Log::debug($request->image->getClientOriginalName());
        //if($request->hasFile())
        // {
        //     $urls = ImageRepository::uploadImage($request[$fileColumnName],);
        // }
        if ($user->imageCount() > 0) {
            $this->_imageManager->deleteImage($user->images[0]->path, $user->images[0]->filename);
            $user->images[0]->delete();
        }


        $url = $this->_imageManager->uploadImage($request->image, $uploadPath, $fileName);
        Log::debug($url);

        $image = $user->images()->create([
            'user_id' => $request->user()->id,
            'url' => $url,
            // 'url_thumb' => $url_thumb,
            'is_main' => true,
            'path' => $uploadPath,
            'filename' => $fileName,
        ]);

        // $image = UserImage::create([
        //     'user_id' => $request->user()->id,
        //     'url' => $url,
        //     // 'url_thumb' => $url + 'thumb', TODO: Need to build thumb url somehow
        //     'is_main' => true
        // ]);
        Log::debug($image);

        return new ImageResource($image);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
