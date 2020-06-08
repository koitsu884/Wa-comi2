<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use App\Http\Filters\PostFilter;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends ApiController
{
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
    public function show($id)
    {
        $post = Post::with(['category', 'user', 'area'])->firstWhere('id', $id);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return $this->showOne($post);
    }
}
