<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupPostImage extends Image
{
    public function post(){
        return $this->imageable();
    }
}
