<?php

namespace App\Http\Filters;

class DoctorFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name'
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
                        $query->where('name', 'like', '%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }

}
