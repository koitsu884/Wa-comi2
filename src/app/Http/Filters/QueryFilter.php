<?php
//https://blog.jgrossi.com/2018/queryfilter-a-model-filtering-concept/

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

abstract class QueryFilter
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Builder
     */
    protected $builder;


    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    // public function hasLimit()
    // {
    //     return $this->request->has('limit');
    // }

    /**
     * @param Builder $builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $field => $value) {
            $method = camel_case($field);
            if (method_exists($this, $method)) {
                call_user_func([$this, $method], $value);
            }
        }
    }

    protected function wordsFilter(string $column, string $searchWords)
    {
        $words = array_filter(explode(' ', $searchWords));

        $this->builder->where(function (Builder $query) use ($column, $words) {
            foreach ($words as $word) {
                $query->where($column, 'like', "%$word%");
            }
        });
    }

    protected function limit($max)
    {
        $this->builder->limit($max);
    }

    // /**
    //  * @return array
    //  */
    // protected function fields(): array
    // {
    //     return array_filter(
    //         array_map('trim', $this->request->all())
    //     );
    // }
}
