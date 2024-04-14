<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\SubStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubStatusResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SubStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
       return SubStatusResource::collection(SubStatus::paginate());
    }
    /**
     * Display the specified resource.
     *
     * @param  SubStatus  $subStatus
     * @return SubStatusResource
     */
    public function show(SubStatus $subStatus)
    {
        return new SubStatusResource($subStatus);
    }
}
