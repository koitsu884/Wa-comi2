<?php

namespace App\Http\Filters;

class GroupFilter extends QueryFilter
{
    public function name(string $searchWords)
    {
        $this->wordsFilter('name', $searchWords);
    }

    public function description(string $searchWords)
    {
        $this->wordsFilter('description', $searchWords);
    }

    public function user(int $userId)
    {
        $this->builder->where('user_id', $userId);
    }

    public function category(int $categoryId)
    {
        $this->builder->where('group_category_id', $categoryId);
    }

    public function categories($categoryIds)
    {
        $this->builder->whereIn('group_category_id', $categoryIds);
    }

    public function area(int $areaId)
    {
        $this->builder->where('area_id', $areaId);
    }
}
