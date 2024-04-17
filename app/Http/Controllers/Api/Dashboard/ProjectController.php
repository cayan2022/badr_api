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
//        if ($request->filled('ar') || $request->filled('en')) {
//            foreach (app()->getLocale() as $language) {
//                if (isset($request[$language]['title'])) {
//                    $titles = $request[$language]['title'];
//                    foreach ($titles as $title) {
//                        $businessDomain = new BusinessDomain([
//                            'title' => $title,
//                            'project_id' => $project->id,
//                        ]);
//                        $project->businessDomains()->save($businessDomain);
//                    }
//                }
//            }
//        }
        dd(app()->getLocales());
        foreach (app()->getLocale() as $language) {
//            if (isset($request[$language]['title'])) {
//                $titles = $request[$language]['title'];
//                foreach ($titles as $title) {
//                    $businessDomain = new BusinessDomain([
//                        'title' => $title,
//                        'project_id' => $project->id,
//                    ]);
//                    $project->businessDomains()->save($businessDomain);
//                }
//            }
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
                $sliderImage = $slider->store('project_sliders');
                // Assuming you want to store multiple sliders, you should use an array
                $validatedData['project_sliders'][] = $sliderImage;
            }
        }
        if ($request->filled('ar') || $request->filled('en')) {
            $updatedTitles = [];
            foreach (['ar', 'en'] as $language) {
                if (isset($request[$language]['title'])) {
                    $updatedTitles[$language] = $request[$language]['title'];
                }
            }
            foreach ($updatedTitles as $language => $titles) {
                $existingDomains = $project->businessDomains()->where('language', $language)->get();
                foreach ($titles as $title) {
                    $businessDomain = $existingDomains->firstWhere('title', $title);
                    if ($businessDomain) {
                        $businessDomain->update(['title' => $title]);
                    } else {
                        $businessDomain = new BusinessDomain([
                            'title' => $title,
                            'project_id' => $project->id,
                            'language' => $language,
                        ]);
                        $project->businessDomains()->save($businessDomain);
                    }
                }
                foreach ($existingDomains as $existingDomain) {
                    if (!in_array($existingDomain->title, $titles)) {
                        $existingDomain->delete();
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
