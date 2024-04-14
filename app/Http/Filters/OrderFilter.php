<?php

namespace App\Http\Filters;

use App\Models\OrderHistory;
use App\Models\User;
use Carbon\Carbon;

class OrderFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'user',
        'category',
        'status',
        'source',
        'today',
        'yesterday',
        'this_weak',
        'last_weak',
        'this_month',
        'last_month',
        'this_year',
        'last_year',
        'start_date',
        'employee'
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function category($value)
    {
        if ($value) {
            $categories = \App\Models\Translations\CategoryTranslation::where('name', 'like', $value)->pluck('category_id');
            return $this->builder->whereIn('category_id', $categories);
        }

        return $this->builder;
    }

    protected function status($value)
    {
        if ($value) {
            $statuses = \App\Models\Translations\StatusTranslation::where('name', 'like', $value)->pluck('status_id');
            return $this->builder->whereIn('status_id', $statuses);
        }

        return $this->builder;
    }

    protected function source($value)
    {
        if ($value) {
            $souces = \App\Models\Translations\SourceTranslation::where('name', 'like', $value)->pluck('source_id');
            return $this->builder->whereIn('source_id', $souces);
        }

        return $this->builder;
    }

    protected function user($value)
    {
        if ($value) {
            $users = \App\Models\User::where('name', 'like', '%' . $value . '%')
                ->orWhere('phone', 'like', '%' . $value . '%')
                ->orWhere('email', 'like', '%' . $value . '%')
                ->pluck('id');
            return $this->builder->whereIn('user_id', $users);
        }

        return $this->builder;
    }

    protected function today($value)
    {
        if ($value) {
            return $this->builder->whereDate('created_at', '=', Carbon::now()->today()->toDateString());
        }

        return $this->builder;
    }

    protected function yesterday($value)
    {
        if ($value) {
            return $this->builder->whereDate('created_at', '=', Carbon::now()->yesterday()->toDateString());
        }

        return $this->builder;
    }

    protected function thisWeak($value)
    {
        if ($value) {

            return $this->builder->whereBetween('created_at', [Carbon::now()->startOfWeek()->toDateString(), Carbon::now()->endOfWeek()->toDateString()]);
        }

        return $this->builder;
    }

    protected function lastWeak($value)
    {
        if ($value) {

            return $this->builder->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
        }

        return $this->builder;
    }


    protected function thisMonth($value)
    {
        if ($value) {
            return $this->builder->whereBetween('created_at', [Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString()]);
        }

        return $this->builder;
    }

    protected function lastMonth($value)
    {
        if ($value) {
            return $this->builder->whereBetween('created_at', [Carbon::now()->subDays(30)->startOfMonth()->toDateString(), Carbon::now()->subDays(30)->endOfMonth()->toDateString()]);
        }

        return $this->builder;
    }

    protected function sixMonths($value)
    {
        if ($value) {
            return $this->builder->whereBetween(
                'created_at',
                [Carbon::now()->subMonths(6)->toDateString(), Carbon::now()->toDateString()]
            );
        }

        return $this->builder;
    }

    protected function thisYear($value)
    {
        if ($value) {
            return $this->builder->whereBetween(
                'created_at',
                [
                    Carbon::now()->startOfYear()->toDateString(), Carbon::now()->endOfYear()->toDateString(),
                ]
            );
        }

        return $this->builder;
    }

    protected function lastYear($value)
    {
        if ($value) {
            return $this->builder->whereBetween(
                'created_at',
                [Carbon::now()->subYear()->toDateString(), Carbon::now()->toDateString()]
            );
        }

        return $this->builder;
    }

    public function startDate($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('start_date') && $this->request->filled('end_date'),
                    function ($query) {
                        $query->whereBetween(
                            'created_at',
                            [
                                $this->request->get('start_date'),
                                $this->request->get('end_date')
                            ]
                        );
                    }
                );
        }

        return $this->builder;
    }

    protected function employee($value)
    {
        if ($value) {
            $user = User::where('name', $value)->first();
            $order_ids = OrderHistory::where('user_id', $user->id)->groupBy('order_id')->pluck('order_id');

            return $this->builder->whereIn('id', $order_ids);
        }

        return $this->builder;
    }
}