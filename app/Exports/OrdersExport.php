<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrdersExport implements FromQuery, WithHeadings,WithMapping,ShouldAutoSize
{
    public function headings(): array
    {
        return [
            '# ID',
            'Created at',
            'Branch',
            'Source',
            'Category',
            'Status',
            'Customer',
            'Mobile',
            'Employee',
            'Last Action',
            'Last Action Time',
            'Last Action Note'
        ];
    }
    use Exportable;

    public function query()
    {
        return Order::query()->filter();
    }

    /**
     * @return array
     * @var Order $order
     */
    public function map($order): array
    {
        return [
            $order->id,
            $order->created_at,
            $order->branch->name ?? '',
            $order->source->name ?? '',
            $order->category->name ?? '',
            $order->status->name ?? '',
            $order->user->name ?? '',
            $order->user->country->code . $order->user->phone,
            $order->last_employee ?? '',
            optional($order->histories->last())->substatus->name ?? '',
            optional($order->histories->last())->created_at ?? '',
            optional($order->histories->last())->description ?? '',
        ];
    }
}
