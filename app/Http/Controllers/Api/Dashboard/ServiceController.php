<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreServiceRequest;
use App\Http\Requests\Api\Dashboard\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Helpers\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Response;

class ServiceController extends Controller
{

    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ServiceResource::collection(Service::filter()->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreServiceRequest  $request
     * @return ServiceResource
     */
    public function store(StoreServiceRequest $request)
    {
        $service= Service::create($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $service->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Service::MEDIA_COLLECTION_NAME);
        }
        return $service->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  Service  $service
     * @return ServiceResource
     */
    public function show(Service $service)
    {
        return $service->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateServiceRequest  $request
     * @param  Service  $service
     * @return ServiceResource
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $service->clearMediaCollection(Service::MEDIA_COLLECTION_NAME);
            $service->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Service::MEDIA_COLLECTION_NAME);
        }
        return $service->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Service  $service
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  Service $service
     * @return Application|ResponseFactory|Response
     */
    public function block(Service $service)
    {
        $service->block();
        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  Service $service
     * @return Application|ResponseFactory|Response
     */
    public function active(Service $service)
    {
        $service->active();
        return $this->success(__('auth.success_operation'));
    }
}
