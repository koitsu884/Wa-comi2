<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Filters\PostFilter;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PostResource;
use App\Contracts\ImageManagerContract;
use App\Http\Controllers\ApiController;

class PostController extends ApiController
{
    private $_imageManager;
    public function __construct(ImageManagerContract $imageManager)
    {
        parent::__construct();

        $this->middleware('auth.api')->except(['index', 'show']);
        $this->middleware('can:update,post')->only('update');
        $this->middleware('can:delete,post')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostFilter $filter)
    {
        // return $this->showAll($posts);
        $filteredPost = Post::filter($filter)
            ->orderBy('updated_at', 'desc')
            ->with(['category', 'user', 'area']);

        $perPage = $filter->getRequest()->per_page ?? 12;

        return PostResource::collection($filteredPost->paginate($perPage));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource($post->load(['category', 'user', 'area', 'images']));
    }

       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:100',
            'content' => 'required|max:5000',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        $post = Post::create($data);

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $rules = [
            'title' => 'max:100',
            'content' => 'max:5000',
        ];

        $this->validate($request, $rules);

        // $this->checkUser($user, $post);

        $post->fill($request->all());

        if ($post->isClean()) {
            return $this->errorResponse('Nothing changed', 422);
        }

        $post->save();

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        
        return new PostResource($post);
    }
}
