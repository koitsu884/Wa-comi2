<?php

namespace App\Http\Controllers\Group;

use App\Models\Group;
use App\Models\GroupPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreGroupPost;
use App\Http\Requests\UpdateGroupPost;
use App\Http\Controllers\ApiController;
use App\Http\Resources\GroupPostResource;
use App\Http\Resources\GroupPostListResource;

class GroupPostController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.api')->except('index');
        $this->middleware('can:create, App\Models\GroupPost')->only('store');
        $this->middleware('can:update,post')->only('update');
        $this->middleware('can:delete,post')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Group $group)
    {
        if($request->get('latest', false)){
            return GroupPostResource::collection($group->posts()->take(3)->get());
        } 
        $posts = $group->posts()->get();
        return $request->get('list', false) ? GroupPostListResource::collection($posts) : GroupPostResource::collection($posts) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupPost $request, Group $group)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        $data['group_id'] = $group->id;

        $group = GroupPost::create($data);

        return new GroupPostResource($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroupPost  $groupPost
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group, GroupPost $post)
    {
        return new GroupPostResource($post->load(['user', 'images']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GroupPost  $groupPost
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupPost $request, Group $group, GroupPost $post)
    {
        $data = $request->validated();
        $post->fill($data);

        if ($post->isClean()) {
            return $this->errorResponse('Nothing changed', 422);
        }

        $post->save();

        return new GroupPostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupPost  $groupPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group, GroupPost $post)
    {
        $post->delete();
        return new GroupPostResource($post);
    }
}
