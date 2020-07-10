<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/**
 * Users
 */
Route::resource('users', 'User\UserController', ['except' => ['store', 'edit', 'create']]);
// Route::resource('users.images', 'User\UserImageController', ['only' => ['store', 'destroy']]);
Route::name('users.avatar.show')->get('users/{user}/avatar', 'User\UserImageController@show');
Route::name('users.avatar.store')->post('users/{user}/avatar', 'User\UserImageController@store');
Route::name('users.avatar.destroy')->delete('users/{user}/avatar', 'User\UserImageController@destroy');
Route::resource('userinvitations', 'User\UserInvitationController', ['only' => ['index', 'update', 'destroy'], 'parameters' => ['userinvitations' => 'invitation']]);

// Route::resource('profiles', 'User\UserProfileController', ['only' => ['index']]);
// Route::resource('users.profiles', 'User\UserProfileController', ['only' => ['store', 'show', 'update']]);
Route::resource('users.posts', 'User\UserPostController', ['only' => ['index', 'show']]);
Route::resource('users.groups', 'User\UserGroupController', ['only' => ['index', 'show']]);
Route::name('verify')->get('users/verify/{token}', 'User\UserController@verify');
Route::name('users.search')->get('users/search/{search}', 'User\UserController@search');

/**
 * User Posts
 */
Route::resource('posts', 'Post\PostController', ['except' => ['edit', 'create']]);
Route::resource('posts.comments', 'Post\PostCommentController', ['only' => ['store', 'index', 'destroy']]);
Route::resource('posts.images', 'Post\PostImageController', ['only' => ['store', 'destroy', 'index']]);
Route::name('posts.images.setmain')->patch('posts/{post}/images/{image}/setmain', 'Post\PostImageController@setMainImage');
Route::resource('postcategories', 'Post\PostCategoryController', ['only' => ['index']]);

/**
 * Groups
 */
Route::resource('groups', 'Group\GroupController', ['except' => ['edit', 'create']]);
Route::resource('groups.images', 'Group\GroupImageController', ['only' => ['store', 'destroy', 'index']]);
Route::name('groups.images.setmain')->patch('groups/{group}/images/{image}/setmain', 'Group\GroupImageController@setMainImage');
Route::resource('groupcategories', 'Group\GroupCategoryController', ['only' => ['index']]);

/**
 * Group Member
 */
Route::resource('groups.members', 'Group\GroupMemberController', ['except' => ['edit', 'create']]);
Route::resource('groups.invitations', 'Group\GroupInvitationController', ['only' => ['index', 'store', 'destroy']]);

/**
 * Group Post
 */
Route::resource('groups.posts', 'Group\GroupPostController', ['except' => ['edit', 'create']]);
Route::resource('groups.posts.images', 'Group\GroupPostImageController', ['only' => ['store', 'destroy', 'index']]);

/**
 * Etc
 */
Route::resource('comments.replies', 'CommentReplyController', ['only' => ['index', 'store', 'destroy']]);
Route::resource('areas', 'AreaController', ['only' => ['index', 'store']]);

/**
 * Auth
 */
Route::prefix('auth')->group(function () {
    Route::name('register')->post('register', 'Auth\AuthController@register');
    Route::name('login')->post('login', 'Auth\AuthController@login');
    Route::name('refresh')->get('refresh', 'Auth\AuthController@refresh');
    Route::middleware('auth.api')->group(function () {
        Route::name('me')->get('me', 'Auth\AuthController@currentUser');
        Route::name('logout')->get('logout', 'Auth\AuthController@logout');
    });
});
