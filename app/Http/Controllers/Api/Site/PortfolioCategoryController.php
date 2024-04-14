<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioCategoryResource;
use App\Models\PortfolioCategory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortfolioCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return AnonymousResourceCollection
     */
    public function __invoke(): AnonymousResourceCollection
    {
        return PortfolioCategoryResource::collection(PortfolioCategory::whereIsActive()->filter()->latest()->paginate());
    }
}