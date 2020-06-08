<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupCategoryResource;
use App\Models\GroupCategory;
use Illuminate\Http\Request;

class GroupCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GroupCategoryResource::collection(GroupCategory::all());
    }
}
