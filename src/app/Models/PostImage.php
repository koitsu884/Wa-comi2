<?php

namespace App\Models;

class PostImage extends Image
{
    public function post(){
        return $this->imageable();
    }
}
