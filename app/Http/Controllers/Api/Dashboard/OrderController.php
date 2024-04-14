<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Order;
use App\Models\OrderHistory;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderHistoryResource;
use App\Http\Requests\Api\Dashboard\StoreOrderRequest;
use App\Http\Requests\Api\Dashboard\FollowOrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->status == 'متابعة') {
            $orders = Order::filter()->orderBy(OrderHistory::select('order_histories.duration')->whereColumn('order_histories.order_id', 'orders.id')->latest()->take(1), 'asc')->paginate();
        } else {
            $orders = Order::filter()->latest()->paginate();
        }

        return OrderResource::collection($orders);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return OrderResource
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  Order  $order
     * @return OrderResource
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function follow(FollowOrderRequest $request)
    {
        return new OrderHistoryResource(
            //it will observe order to update its status to the current status -> when order history created
            OrderHistory::create(
                $request->validated() + ['user_id' => auth()->user()->id]
            )
        );
    }
}