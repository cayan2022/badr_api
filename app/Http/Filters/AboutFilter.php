<?php

namespace App\Http\Filters;

class AboutFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'title'
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

}
