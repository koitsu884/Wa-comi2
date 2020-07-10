<?php

namespace App\Models;

class GroupImage extends Image
{
    public function group(){
        return $this->imageable();
    }
}
