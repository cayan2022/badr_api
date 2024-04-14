<?php

namespace App\Http\Controllers\Api\Site;

use App\Models\Portfolio;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PortfolioResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortfolioController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        return PortfolioResource::collection(Portfolio::whereIsActive()->filter()->latest()->get());
    }
}
