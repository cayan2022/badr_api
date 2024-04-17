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
            $project->clearMediaCollection(Project::MEDIA_COLLECTION_NAME_DEVELOPER);
            $project->addMediaFromRequest('developer_image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Project::MEDIA_COLLECTION_NAME_DEVELOPER);
        }


        // Store owner name and image
        if ($request->hasFile('owner_image') && $request->file('owner_image')->isValid()) {
            $project->clearMediaCollection(Project::MEDIA_COLLECTION_NAME_OWNER);
            $project->addMediaFromRequest('owner_image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Project::MEDIA_COLLECTION_NAME_OWNER);
        }
        // Store project sliders
        if ($request->hasFile('project_sliders')) {
            // Clear the media collection before adding new sliders
            $project->clearMediaCollection(Project::MEDIA_COLLECTION_NAME_SLIDER);

            foreach ($request->file('project_sliders') as $slider) {
                $project->addMedia($slider)
                    ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                    ->toMediaCollection(Project::MEDIA_COLLECTION_NAME_SLIDER);
            }
        }
        if ($request->filled('ar') || $request->filled('en')) {
            foreach (['ar', 'en'] as $language) {
                if (isset($request[$language]['title'])) {
                    $titles = $request[$language]['title'];
                    foreach ($titles as $title) {
                        $businessDomain = new BusinessDomain([
                            'project_id' => $project->id,
                            'language' => $language,
                        ]);
                        $businessDomain->translateOrNew($language)->title = $title;
                        $businessDomain->save();
                    }
                }
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
        if ($request->hasFile('owner_image') && $request->file('owner_image')->isValid()) {
            $project->clearMediaCollection(Project::MEDIA_COLLECTION_NAME_OWNER);
            $project->addMediaFromRequest('owner_image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Project::MEDIA_COLLECTION_NAME_OWNER);
        }
        if ($request->hasFile('developer_image') && $request->file('developer_image')->isValid()) {
            $project->clearMediaCollection(Project::MEDIA_COLLECTION_NAME_DEVELOPER);
            $project->addMediaFromRequest('developer_image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Project::MEDIA_COLLECTION_NAME_DEVELOPER);
        }
        // Update project sliders if provided
        if ($request->hasFile('project_sliders')) {
            // Clear the media collection before adding new sliders
            $project->clearMediaCollection(Project::MEDIA_COLLECTION_NAME_SLIDER);

            foreach ($request->file('project_sliders') as $slider) {
                $project->addMedia($slider)
                    ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                    ->toMediaCollection(Project::MEDIA_COLLECTION_NAME_SLIDER);
            }
        }
        // Update BusinessDomain translations
        if ($request->filled('ar') || $request->filled('en')) {
            foreach (['ar', 'en'] as $language) {
                if (isset($request[$language]['title'])) {
                    $titles = $request[$language]['title'];
                    foreach ($titles as $titleId => $title) {
                        // Retrieve the BusinessDomain instance by project_id
                        $businessDomain = BusinessDomain::where('project_id', $project->id)->first();
                        // If BusinessDomain doesn't exist, create a new one
                        if (!$businessDomain) {
                            $businessDomain = new BusinessDomain(['project_id' => $project->id]);
                        }
                        // Set the translation for the title attribute
                        $businessDomain->translateOrNew($language)->title = $title;
                        // Save the BusinessDomain instance
                        $businessDomain->save();
                    }
                }
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
