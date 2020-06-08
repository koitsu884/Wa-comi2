<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserPostController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth.api')->except('index');
        $this->middleware('can:update,post')->only('update');
        $this->middleware('can:delete,post')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $posts = $user->posts;

        // return $this->showAll($posts);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        Log::debug($request);
        $rules = [
            'title' => 'required|max:100',
            'content' => 'required|max:5000',
            'main_image' => 'image|max:2000',
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        // $data['image'] = $request->image->store(''); //Laravel will generate path automatically
        $data['user_id'] = $user->id;

        // if ($request->hasFile('main_image')) {
        //     $path = Storage::disk('s3')->put("images/posts/{$user->id}", $request->main_image);
        //     $data['main_image'] = Storage::disk('s3')->url($path);
        // }
        $this->_uploadImageFromRequest($request, $data, "images/posts/{$user->id}", true);

        $post = Post::create($data);

        // return $this->showOne($post, 201);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Post $post)
    {
        Log::debug($request);
        $rules = [
            'title' => 'max:100',
            'content' => 'max:5000',
            'image' => 'image',
        ];

        $this->validate($request, $rules);

        // $this->checkUser($user, $post);

        $post->fill($request->all());

        // if($request->hasFile('image')){
        //     Storage::delete($post->image);

        //     $post->image = $request->image->store('');
        // }

        if ($post->isClean()) {
            return $this->errorResponse('Nothing changed', 422);
        }

        $post->save();

        // return $this->showOne($post);
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Post $post)
    {
        // $this->checkUser($user, $post);
        // Storage::delete($product->image);
        $post->delete();
        // return $this->showOne($post);
        return new PostResource($post);
    }

    // protected function checkUser(User $user, Post $post)
    // {
    //     if ($user->id != $post->user_id) {
    //         throw new HttpException(422, 'The specified user is not the owner of the post');
    //     }
    // }
}
