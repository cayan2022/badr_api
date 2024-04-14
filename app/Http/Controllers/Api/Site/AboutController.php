<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Models\About;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AboutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return AnonymousResourceCollection
     */
    public function __invoke(): AnonymousResourceCollection
    {
        return AboutResource::collection(About::whereIsActive()->filter()->latest()->paginate());
    }
}
