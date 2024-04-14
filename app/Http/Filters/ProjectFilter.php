<?php

namespace App\Http\Filters;

class ProjectFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'classification'
    ];

    /**
     * Filter the query by a given name.
     *
     * @param  string|int  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('name'),
                    function ($query) use ($value) {
                        $query->whereTranslationLike('name','%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }    /**
     * Filter the query by a given name.
     *
     * @param  string|int  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function classification($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('classification'),
                    function ($query) use ($value) {
                        $query->whereTranslationLike('classification','%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }
}
