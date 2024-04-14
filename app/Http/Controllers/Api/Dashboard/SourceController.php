<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Source;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SourceResource;
use App\Helpers\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Requests\Api\Dashboard\StoreSourceRequest;
use App\Http\Requests\Api\Dashboard\UpdateSourceRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SourceController extends Controller
{

    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return SourceResource::collection(Source::filter()->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreSourceRequest  $request
     * @return Response
     */
    public function store(StoreSourceRequest $request)
    {
        $source = Source::create($request->validated());
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $source->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Source::MEDIA_COLLECTION_NAME);
        }
        return $source->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  Source  $source
     * @return SourceResource
     */
    public function show(Source $source)
    {
        return $source->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateSourceRequest  $request
     * @param  Source  $source
     * @return SourceResource
     */
    public function update(UpdateSourceRequest $request, Source $source)
    {
        $source->update($request->validated());
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $source->clearMediaCollection(Source::MEDIA_COLLECTION_NAME);
            $source->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Source::MEDIA_COLLECTION_NAME);
        }

        return $source->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   Source $source
     * @return Response
     */
    public function destroy(Source $source): Response
    {
        $source->delete();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  Source  $source
     * @return Application|ResponseFactory|Response
     */
    public function block(Source $source)
    {
        $source->block();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param   Source $source
     * @return Application|ResponseFactory|Response
     */
    public function active(Source $source)
    {
        $source->active();
        return $this->success(__('auth.success_operation'));
    }
}
