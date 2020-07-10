<?php

namespace App\Http\Controllers\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\GroupInvitation;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreGroupInvitation;
use App\Http\Resources\InvitedUserResource;
use App\Http\Resources\GroupInvitationResource;

class GroupInvitationController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.api')->except('index');
    //    $this->middleware('can:update,group')->only('store');
        $this->middleware('can:create, App\Models\GroupInvitation')->only('store');
        $this->middleware('can:update,invitation')->only('update');
        $this->middleware('can:delete,invitation')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        $invitedUsers = $group->invitations()->get();

        //return $invitedUsers;

        return GroupInvitationResource::collection($invitedUsers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupInvitation $request, Group $group)
    {
        // $requestUserId = (int)$request->user()->id;
        // $groupId = $group->id;
        // $rules = [
        //     'invited_user_id' => [
        //         'required',
        //         'exists:users,id',
        //         'not_in:'.$requestUserId,
        //         Rule::unique('group_invitations',  'invited_user_id')->where(function ($query) use ($groupId){
        //             return $query->where('group_id', $groupId);
        //         })
        //     ],
        //     'message' => 'nullable|max:1000',
        // ];

        // $this->validate($request, $rules);
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        $data['group_id'] = $group->id;

        $group = GroupInvitation::create($data);

        return new GroupInvitationResource($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupInvitation  $groupInvitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group, GroupInvitation $invitation)
    {
        $invitation->delete();
        return new GroupInvitationResource($invitation);
    }
}
