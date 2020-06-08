<?php

namespace App\Http\Group\Controllers;

use App\Models\Group;
use App\Models\Image;

class GroupImageController extends Controller
{
    public function index(Group $group)
    {
        return ImageResource::collection($group->images());
    }

    public function store(Request $request, Group $group)
    {
        //Should upload image here and get url and url_thumb;
        $url = 'https://res.cloudinary.com/nzworks/image/upload/v1582075194/user/5e4c7712bd2b5b00173964ef/UTNZ%20Banner.jpg_1582075193920.png';
        $url_thumb = 'https://res.cloudinary.com/nzworks/image/upload/c_thumb,w_200/v1582075194/user/5e4c7712bd2b5b00173964ef/UTNZ%20Banner.jpg_1582075193920.png';

        $group->images()->create([
            'user_id' => $request->user()->id,
            'url' => $url,
            'url_thumb' => $url_thumb,
        ]);

        return ImageResource::collection($group->images());
    }

    public function destroy(Group $group, Image $image)
    {
        $this->checkUser(Auth::user(), $group, $image);

        $image->delete();
        return new ImageResource($image);
    }

    protected function checkUser(User $user, Group $group, Image $image)
    {
        if ($user->id != $group->user_id && $user->id != $image->user_id) {
            throw new HttpException(422, 'The specified user is not the owner of the post');
        }
    }
}
