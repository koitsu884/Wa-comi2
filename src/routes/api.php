<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/**
 * Users
 */
Route::resource('users', 'User\UserController', ['except' => ['store']]);
Route::resource('users.images', 'User\UserImageController', ['only' => ['store', 'index', 'destroy']]);

// Route::resource('profiles', 'User\UserProfileController', ['only' => ['index']]);
// Route::resource('users.profiles', 'User\UserProfileController', ['only' => ['store', 'show', 'update']]);
Route::resource('users.posts', 'User\UserPostController', ['except' => ['create', 'show', 'edit']]);
Route::name('verify')->get('users/verify/{token}', 'User\UserController@verify');

/**
 * User Posts
 */
Route::resource('posts', 'Post\PostController', ['only' => ['index', 'show']]);
Route::resource('posts.comments', 'Post\PostCommentController', ['only' => ['store', 'index']]);
Route::resource('posts.images', 'Post\PostImageController', ['only' => ['store', 'index']]);
Route::resource('postcategories', 'Post\PostCategoryController', ['only' => ['index']]);

/**
 * Groups
 */
Route::resource('groups', 'Group\GroupController', ['only' => ['index', 'show']]);
Route::resource('groupcategories', 'Group\GroupCategoryController', ['only' => ['index']]);

/**
 * Etc
 */
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
