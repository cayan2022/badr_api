<?php

namespace App\Http\Filters;

class BlogFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'title',
        'short_description',
    ];

    /**
     * Filter the query by a given title.
     *
     * @param  string|int  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function title($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('title'),
                    function ($query) use ($value) {
                        $query->whereTranslationLike('title', '%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }
    /**
     * Filter the query by a given title.
     *
     * @param  string|int  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function shortDescription($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('short_description'),
                    function ($query) use ($value) {
                        $query->whereTranslationLike('short_description', '%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }

}
