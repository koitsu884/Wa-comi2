<?php

namespace App\Http\Controllers;

use App\Http\Resources\AreaResource;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AreaResource::collection(Area::all());
    }

    public function store(Request $request)
    {
        Log::debug($request);
        return AreaResource::collection(Area::all());
    }
}
