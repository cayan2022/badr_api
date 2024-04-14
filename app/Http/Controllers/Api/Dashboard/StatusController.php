<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\OrderHistory;
use App\Models\Status;
use App\Models\SubStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use App\Http\Resources\SubStatusResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
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

    /**
     * Display the specified resource.
     *
     * @param Status $status
     * @return StatusResource
     */
    public function show(Status $status): StatusResource
    {
        return new StatusResource($status);
    }

    public function substatuses(Status $status): AnonymousResourceCollection
    {
        return SubStatusResource::collection(SubStatus::where('status_id', $status->id)->paginate());
    }
}