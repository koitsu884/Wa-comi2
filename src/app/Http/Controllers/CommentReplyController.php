<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\ReplyResource;
use App\Http\Controllers\ApiController;

class CommentReplyController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth.api')->except(['index', 'show']);
        $this->middleware('can:delete,reply')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Comment $comment)
    {
        return ReplyResource::collection($comment->replies()->orderByDesc('created_at')->with('user')->paginate(3));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Comment $comment)
    {
        $rules = [
            'reply' => 'required|max:1000',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $data['comment_id'] = $comment->id;

        $reply = Reply::create($data);

        return new ReplyResource($reply);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment, Reply $reply)
    {
        $reply->delete();
        
        return new ReplyResource($reply);
    }
}
