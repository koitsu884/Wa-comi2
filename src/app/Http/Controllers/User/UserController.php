<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth.api')->except(['index', 'show']);
        $this->middleware('can:update,user')->only('update');
        // $this->middleware('can:update,user')->only(['update', 'deleteAvatar']);
        $this->middleware('can:delete,user')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //TODO: Could be used only by Admin
    public function index()
    {
        $users = User::all();

        // return $this->showAll($users);
        return UserResource::collection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    // public function store(Request $request, User $user)
    // {
    //     $rules = [
    //         'name' => 'required|min:2|max:100',
    //     ];

    //     $this->validate($request, $rules);

    //     $data = $request->all();
    //     $data['user_id'] = $user->id;

    //     $userProfile = User::create($data);

    //     // return $this->showOne($userProfile, 201);
    //     return new UserResource($user);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        Log::debug($request);
        Log::debug($user);

        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'name' => 'min:2|max:100',
            'introduction' => 'max:5000',
            'twitter' => 'max:200',
            'facebook' => 'max:200',
            'instagram' => 'max:200',
        ];

        $this->validate($request, $rules);

        if ($request->has('email') && $user->email != $request->email) {
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
            $user->email_verified_at = null;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('admin')) {
            if ($user->isVerified() && $request->user()->admin) {
                return $this->errorResponse('Only verified users can modify the admin field', 409);
                // return response()->json(['error'=>'Only verified users can modify the admin field', 'code'=>409], 409);
            }

            $user->admin = $request->admin;
        }

        // $this->_uploadImageFromRequest($request, $user, "images/users/{$user->id}", true, 'avatar');

        $user->fill($request->except(['email', 'password', 'admin']));

        if (!$user->isDirty()) {
            return $this->errorResponse('No change detected', 422);
            // return response()->json(['error'=>'No change detected', 'code'=>422], 422);
        }

        $user->save();

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return new UserResource($user);
    }

    public function deleteAvatar($id)
    {
        Log::debug($id);
        Log::debug('deleting');
        // $this->_deleteImageFromRequest($user, 'avatar');
        // Log::debug($user);
        // $user->save();
        // return new UserResource($user);
        return $this->successResponse('ok', 200);
    }
}
