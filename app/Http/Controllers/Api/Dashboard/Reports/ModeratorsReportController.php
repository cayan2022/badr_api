<?php

namespace App\Http\Controllers\Api\Dashboard\Reports;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Reports\ModeratorsReportResource;

class ModeratorsReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke(Request $request)
    {
        return ModeratorsReportResource::collection(User::where('type',User::MODERATOR)->filter()->latest()->paginate());
    }
}
