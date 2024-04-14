<?php

namespace App\Http\Controllers\Api\Dashboard\Reports;

use App\Models\Source;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Reports\SourcesReportResource;

class SourcesReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke(Request $request)
    {
        return SourcesReportResource::collection(Source::filter()->get());
    }
}
