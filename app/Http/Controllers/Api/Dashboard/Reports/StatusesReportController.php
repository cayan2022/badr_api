<?php

namespace App\Http\Controllers\Api\Dashboard\Reports;

use App\Models\OrderHistory;
use App\Models\Status;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\StatusResource;

class StatusesReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke(Request $request)
    {
        if ($request->filled('start_date') && $request->filled('end_date') && $request->filled('employee')) {
            $user = User::where('name', $request->get('employee'))->first();
            $order_ids = OrderHistory::where('user_id', $user->id)->groupBy('order_id')->pluck('order_id');

            $statuses = Status::withCount([
                'orders' => function ($query) use ($request, $order_ids) {
                    $query->whereBetween('created_at', [$request->get('start_date'), $request->get('end_date')])
                        ->whereIn('id', $order_ids);
                },
            ])->filter()->get();

        } elseif ($request->filled('start_date') && $request->filled('end_date') && !$request->filled('employee')) {
            $statuses = Status::withCount([
                'orders' => function ($query) use ($request) {
                    $query->whereBetween(
                        'created_at',
                        [
                            $request->get('start_date'),
                            $request->get('end_date'),
                        ]
                    );
                },
            ])->filter()->get();
        } elseif (!$request->filled('start_date') && !$request->filled('end_date') && $request->filled('employee')) {
            $user = User::where('name', $request->get('employee'))->first();
            $order_ids = OrderHistory::where('user_id', $user->id)->groupBy('order_id')->pluck('order_id');
            $statuses = Status::withCount([
                'orders' => function ($query) use ($order_ids) {
                    $query->whereIn('id', $order_ids);
                },
            ])->get();
        } else {
            $statuses = Status::filter()->get();
        }

        return StatusResource::collection($statuses);
    }
}