<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\BusinessDomain;
use App\Models\Project;
use App\Models\Translations\BusinessDomainTranslation;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Helpers\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Requests\Api\Dashboard\StoreProjectRequest;
use App\Http\Requests\Api\Dashboard\UpdateProjectRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        $locales = config('translatable.locales');
        $this->getTranslationsArray($locales, $project, $request);
//        foreach ($locales as $language) {
//            if (isset($request[$language]['title'])) {
//                $titles = $request[$language]['title'];
//                foreach ($titles as $title) {
//                    if ($language == $locales[0]) {
//                        $businessDomain = BusinessDomain::create([
//                            'project_id' => $project->id
//                        ]);
//                        BusinessDomainTranslation::create([
//                            'business_domain_id' => $businessDomain->id,
//                            'locale' => $language,
//                            'title' => $title
//                        ]);
//                    } else {
//                        $businessDomains = BusinessDomain::where('project_id', $project->id)->get();
//                        foreach ($businessDomains as $key => $businessDomain) {
//                            BusinessDomainTranslation::updateOrCreate([
//                                'business_domain_id' => $businessDomain->id,
//                                'locale' => 'ar',
//                            ], [
//                                'title' => $request['ar']['title'][$key],
//                            ]);
//                        }
//                    }
//                }
//            }
//        }
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

        $locales = config('translatable.locales');
        $project->businessDomains()->delete();
        $this->getTranslationsArray($locales, $project, $request);

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

    public function removeMedia($id)
    {
        // Find the media by ID
        $media = Media::findOrFail($id);
        // Delete the media file from the disk and remove the record from the media table
        $media->delete();

        return $this->success(__('auth.success_operation'));
    }


    private function getTranslationsArray($locales, $project, $request)
    {
        foreach ($locales as $language) {
            if (isset($request[$language]['title'])) {
                $titles = $request[$language]['title'];
                foreach ($titles as $title) {
                    if ($language == $locales[0]) {
                        $businessDomain = BusinessDomain::create([
                            'project_id' => $project->id
                        ]);
                        BusinessDomainTranslation::create([
                            'business_domain_id' => $businessDomain->id,
                            'locale' => $language,
                            'title' => $title
                        ]);
                    } else {
                        $businessDomains = BusinessDomain::where('project_id', $project->id)->get();
                        foreach ($businessDomains as $key => $businessDomain) {
                            BusinessDomainTranslation::updateOrCreate([
                                'business_domain_id' => $businessDomain->id,
                                'locale' => 'ar',
                            ], [
                                'title' => $request['ar']['title'][$key],
                            ]);
                        }
                    }
                }
            }
        }
    }
}
