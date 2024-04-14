<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Project;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Helpers\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Requests\Api\Dashboard\StoreProjectRequest;
use App\Http\Requests\Api\Dashboard\UpdateProjectRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    use RespondsWithHttpStatus;

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ProjectResource::collection(Project::filter()->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreProjectRequest  $request
     * @return ProjectResource
     */
    public function store(StoreProjectRequest $request): ProjectResource
    {
        $project = Project::create($request->validated());
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $project->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Project::MEDIA_COLLECTION_NAME);
        }
        return $project->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  Project  $project
     * @return ProjectResource
     */
    public function show(Project $project): ProjectResource
    {
        return $project->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProjectRequest  $request
     * @param  Project  $project
     * @return ProjectResource
     */
    public function update(UpdateProjectRequest $request, Project $project): ProjectResource
    {
        $project->update($request->validated());

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $project->clearMediaCollection(Project::MEDIA_COLLECTION_NAME);
            $project->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Project::MEDIA_COLLECTION_NAME);
        }

        return $project->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Project  $project
     * @return Response
     */
    public function destroy(Project $project): Response
    {
        $project->delete();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  Project  $project
     * @return Application|ResponseFactory|Response
     */
    public function block(Project $project)
    {
        $project->block();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  Project  $project
     * @return Application|ResponseFactory|Response
     */
    public function active(Project $project)
    {
        $project->active();
        return $this->success(__('auth.success_operation'));
    }
}
