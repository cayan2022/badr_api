<?php

namespace App\Http\Resources\Reports;

use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Resources\Json\JsonResource;

class ModeratorsReportResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $orders = Order::whereBetween('updated_at', [$request->get('start_date'), $request->get('end_date')])
                ->whereHas('histories', function ($q) {
                    $q->where('user_id', $this->id);
                })->get();
        } else {
            $orders = Order::whereHas('histories', function ($q) {
                $q->where('user_id', $this->id);
            })->get();
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->getAvatar(),
            'type' => $this->type,
            'total_orders' => (int) $orders->count(),
            'percentage_to_all_orders' => (float) $orders->count() / Order::count(),
            'orders_statuses' => (new StatusReportCollection(Status::all()))->additional(['orders' => $orders]),
        ];
    }
}