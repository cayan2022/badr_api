<?php

namespace App\Http\Filters;

class SourceFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'start_date'
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
                        $query->whereTranslationLike('name', '%'.$value.'%')
                            ->orWhereTranslationLike('short_description', '%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }

    public function startDate($value)
    {
        if ($value) {
            return $this->builder->with('orders')
                ->when(
                    $this->request->filled('start_date') && $this->request->filled('end_date'),
                    function ($query) {
                        $query->whereHas('orders', function ($query) {
                            $query->whereBetween(
                                'created_at',
                                [
                                    $this->request->get('start_date'),
                                    $this->request->get('end_date')
                                ]
                            );
                        });
                    }
                );
        }

        return $this->builder;
    }


}
