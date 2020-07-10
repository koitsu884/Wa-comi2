<?php

namespace App\Http\Controllers\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Controllers\ApiController;
use App\Http\Resources\GroupMemberResource;

class GroupMemberController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:create,App\Models\GroupMember')->only('store');
        $this->middleware('can:update,member')->only('update');
        $this->middleware('can:delete,member')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        //return $group->members()->get();
        return UserResource::collection($group->members()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $data['group_id'] = $group->id;

        $member = GroupMember::create($data);

        return new GroupMemberResource($member);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
