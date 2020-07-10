<?php

namespace App\Models;

class PostComment extends Comment
{
    public function post(){
        return $this->imageable();
    }
}
