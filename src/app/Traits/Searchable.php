<?php

namespace App\Traits;

use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        $filter->apply($builder);
    }
}
