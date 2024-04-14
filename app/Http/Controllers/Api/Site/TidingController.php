<?php

namespace App\Http\Controllers\Api\Site;

use App\Models\Tiding;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TidingResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TidingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        return TidingResource::collection(Tiding::whereIsActive()->filter()->latest()->paginate());
    }
}
