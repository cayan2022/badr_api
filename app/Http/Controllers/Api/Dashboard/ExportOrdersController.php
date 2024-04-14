<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportOrdersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     */
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        $path='orders-excel-exports/orders.xlsx';
         Excel::store(new OrdersExport, $path,'public');
         return response()->json(['file_link'=> asset('storage/'.$path)]);
    }
}
