<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Http\Controllers\ApiController;

class UserGroupController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $groups = [];
        if($request->get('support', false)){
            $groups = $user->supportGroups();
             
        } else if ($request->get('follow', false)){
            //TODO: follow...
            $groups = $user->groups();
        }
        else{
            $groups = $user->groups();
        }

        //return $groups->get();
        return GroupResource::collection($groups->get());
    }
}
