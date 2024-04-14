<?php

namespace App\Http\Filters;

class PortfolioFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'portfolio_category_id',
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
                        $query->whereTranslationLike('name', '%' . $value . '%');
                    }
                );
        }

        return $this->builder;
    }

    /**
     * Filter the query by portfolio category id.
     *
     * @param  string|int  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function portfolioCategoryId($value)
    {
        if ($value) {
            return $this->builder->where('portfolio_category_id', $value);
        }

        return $this->builder;
    }
}