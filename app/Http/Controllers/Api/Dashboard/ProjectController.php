<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\BusinessDomain;
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
     * @param StoreProjectRequest $request
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
        // Store developer name and image
        if ($request->hasFile('developer_image') && $request->file('developer_image')->isValid()) {
            $developerImage = $request->file('developer_image')->store('developer_images');
            $validatedData['developer_image'] = $developerImage;
        }

        // Store owner name and image
        if ($request->hasFile('owner_image') && $request->file('owner_image')->isValid()) {
            $ownerImage = $request->file('owner_image')->store('owner_images');
            $validatedData['owner_image'] = $ownerImage;
        }
        // Store project sliders
        if ($request->hasFile('project_sliders')) {
            foreach ($request->file('project_sliders') as $slider) {
                $project->addMedia($slider)
                    ->toMediaCollection('project_sliders');
            }
        }
        if ($request->filled('business_domains')) {
            foreach ($request->input('business_domains') as $domainData) {
                $businessDomain = new BusinessDomain([
                    'title' => $domainData['title'],
                    'project_id' => $project->id,
                ]);
                $project->businessDomains()->save($businessDomain);
            }
        }

        return $project->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return ProjectResource
     */
    public function show(Project $project): ProjectResource
    {
        return $project->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
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
        // Store developer name and image
        if ($request->hasFile('developer_image') && $request->file('developer_image')->isValid()) {
            $developerImage = $request->file('developer_image')->store('developer_images');
            $validatedData['developer_image'] = $developerImage;
        }

        // Store owner name and image
        if ($request->hasFile('owner_image') && $request->file('owner_image')->isValid()) {
            $ownerImage = $request->file('owner_image')->store('owner_images');
            $validatedData['owner_image'] = $ownerImage;
        }
        // Store or update project sliders
        if ($request->hasFile('project_sliders')) {
            foreach ($request->file('project_sliders') as $slider) {
                $project->addMedia($slider)
                    ->toMediaCollection('project_sliders');
            }
        }
        // Update BusinessDomains
        if ($request->filled('business_domains')) {
            // Delete existing domains
            $project->businessDomains()->delete();

            // Create new domains
            foreach ($request->input('business_domains') as $domainData) {
                $businessDomain = new BusinessDomain([
                    'title' => $domainData['title'],
                    'project_id' => $project->id,
                ]);
                $project->businessDomains()->save($businessDomain);
            }
        }

        return $project->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return Response
     */
    public function destroy(Project $project): Response
    {
        $project->delete();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param Project $project
     * @return Application|ResponseFactory|Response
     */
    public function block(Project $project)
    {
        $project->block();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param Project $project
     * @return Application|ResponseFactory|Response
     */
    public function active(Project $project)
    {
        $project->active();
        return $this->success(__('auth.success_operation'));
    }
}
