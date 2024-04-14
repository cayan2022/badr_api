<?php

namespace App\Http\Resources\Reports;

use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StatusReportCollection extends ResourceCollection
{
    public $collects = StatusResource::class;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            $this->collection
                ->map(fn($item) => collect($item)
                    ->replace([
                                  'orders_count' => (int)$this->additional['orders']->where('status_id', $item->id)->count()
                              ])
                );
    }
}
