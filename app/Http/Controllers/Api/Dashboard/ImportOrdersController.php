<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\OrdersImportRequest;
use App\Imports\OrdersImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportOrdersController extends Controller
{
    /**
     * Handle the incoming request.
     *@return \Illuminate\Http\JsonResponse
     */
    public function __invoke(OrdersImportRequest $request)
    {
        Excel::import(new OrdersImport, request()->file('excel_file'));

        return response()->json(['success' => true, 'message' => __('auth.success_operation')]);
    }
}