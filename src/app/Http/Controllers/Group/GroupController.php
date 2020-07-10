<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\ApiController;
use App\Http\Filters\GroupFilter;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth.api')->except(['index', 'show', 'slugCheck']);
        $this->middleware('can:update,group')->only('update');
        $this->middleware('can:delete,group')->only('destroy');
    }
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
            ->with(['category', 'area', 'user']);

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
        $rules = [
            'slug' => 'required|unique:groups,slug|min:2|max:100',
            'name' => 'required|max:100',
            'description' => 'required|max:5000',
            'homepage' => 'nullable|url|max:200',
            'facebook' => 'nullable|url|max:200',
            'twitter' => 'nullable|url|max:200',
            'instagram' => 'nullable|url|max:200',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        $group = Group::create($data);

        return new GroupResource($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
//        $result = $group->load(['category', 'user', 'area', 'images']);
        return new GroupResource($group->load(['category', 'user', 'area', 'images']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $rules = [
            'slug' => 'min:2|max:100',
            'name' => 'min:2|max:100',
            'description' => 'min:10|max:5000',
            'homepage' => 'nullable|url|max:200',
            'facebook' => 'nullable|url|max:200',
            'twitter' => 'nullable|url|max:200',
            'instagram' => 'nullable|url|max:200',
        ];

        $this->validate($request, $rules);

        // $this->checkUser($user, $post);

        $group->fill($request->all());

        if ($group->isClean()) {
            return $this->errorResponse('Nothing changed', 422);
        }

        $group->save();

        return new GroupResource($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return new GroupResource($group);
    }

    public function slugCheck($slug){
        return $this->showMessage( Group::where('slug', $slug)->exists() ? 'そのIDは既に使用されています' : 'OK');
    }
}
