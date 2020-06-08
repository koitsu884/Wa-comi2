<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use App\Http\Resources\PostCategoryResource;
use App\Models\PostCategory;

class PostCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PostCategoryResource::collection(PostCategory::all());
    }
}
