<?php

namespace App\Http\Filters;

use Illuminate\Support\Facades\Log;

class PostFilter extends QueryFilter
{
    public function title(string $searchWords)
    {
        $this->wordsFilter('title', $searchWords);
    }

    public function content(string $searchWords)
    {
        $this->wordsFilter('content', $searchWords);
    }

    public function user(int $userId)
    {
        $this->builder->where('user_id', $userId);
    }

    public function area(int $areaId)
    {
        $this->builder->where('area_id', $areaId);
    }

    public function category(int $categoryId)
    {
        $this->builder->where('post_category_id', $categoryId);
    }

    public function categories($categoryIds)
    {
        $this->builder->whereIn('post_category_id', $categoryIds);
    }
}
