<?php

namespace App\Http\Controllers\Api\Site;

use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        return ProjectResource::collection(Project::whereIsActive()->filter()->latest()->paginate());
    }
}
