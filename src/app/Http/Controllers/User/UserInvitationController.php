<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Models\UserInvitation;
use App\Models\GroupInvitation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
use App\Http\Requests\UpdateInvitation;
use App\Http\Resources\GroupInvitationResource;

class UserInvitationController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.api');
        $this->middleware('can:update,invitation')->only('update');
        $this->middleware('can:delete,invitation')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groupInvitations = Auth::user()->groupInvitations()->get();

        //return $groupInvitations;

        return GroupInvitationResource::collection($groupInvitations);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GroupInvitation  $groupInvitation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvitation $request, UserInvitation $invitation)
    {
        $validated = $request->validated();
        $invitation->status = $validated['status'];
        $invitation->save();

        return new GroupInvitationResource($invitation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupInvitation  $groupInvitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserInvitation $invitation)
    {
        $invitation->delete();
        return new GroupInvitationResource($invitation);
    }
}
