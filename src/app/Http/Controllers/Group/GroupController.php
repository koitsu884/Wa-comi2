<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Filters\GroupFilter;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends ApiController
{
    // const GROUPS_PER_PAGE = 12;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GroupFilter $filter)
    {
        // return $this->showAll($posts);
        $filteredGroup = Group::filter($filter)
            ->orderBy('updated_at', 'desc')
            ->with(['category', 'user']);

        $perPage = $filter->getRequest()->per_page ?? 12;


        return GroupResource::collection($filteredGroup->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
