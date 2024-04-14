<?php

namespace App\Http\Filters;

class TestimonialFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'user_name'
    ];

    /**
     * Filter the query by a given name.
     *
     * @param  string|int  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function userName($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('user_name'),
                    function ($query) use ($value) {
                        $query->where('user_name', 'like', '%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }

}
