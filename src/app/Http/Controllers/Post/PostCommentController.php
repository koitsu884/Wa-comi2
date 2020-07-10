<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Resources\CommentResource;

class PostCommentController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth.api')->except(['index', 'show']);
        $this->middleware('can:delete,comment')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        return CommentResource::collection($post->comments()->orderByDesc('created_at')->with('user')->withCount('replies')->paginate(3));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $rules = [
            'comment' => 'required|max:1000',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        $comment = $post->comments()->create($data);

        // $post = Post::create($data);

        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostComment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, PostComment $comment)
    {
        $comment->delete();
        
        return new CommentResource($comment);
    }
}
