<?php

namespace App\Models;

use App\Traits\Imageable;
use App\Traits\Commentable;
use App\Traits\Searchable;
use App\Traits\UserRelatable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use UserRelatable;
    use Imageable;
    use Commentable;
    use Searchable;

    protected $fillable = [
        'user_id',
        'post_category_id',
        'title',
        'content',
        // 'main_image',
        'area_id',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id', 'id');
    }
}
