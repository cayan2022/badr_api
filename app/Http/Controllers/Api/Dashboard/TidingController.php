<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreTidingRequest;
use App\Http\Requests\Api\Dashboard\UpdateTidingRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Models\Tiding;
use Illuminate\Http\Response;
use App\Http\Resources\TidingResource;

class TidingController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return TidingResource::collection(Tiding::filter()->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTidingRequest  $request
     * @return TidingResource
     */
    public function store(StoreTidingRequest $request)
    {
        $tiding= Tiding::create($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $tiding->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Tiding::MEDIA_COLLECTION_NAME);
        }
        return $tiding->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  Tiding  $tiding
     * @return TidingResource
     */
    public function show(Tiding $tiding)
    {
        return $tiding->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTidingRequest  $request
     * @param  Tiding  $tiding
     * @return TidingResource
     */
    public function update(UpdateTidingRequest $request, Tiding $tiding): TidingResource
    {
        $tiding->update($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $tiding->clearMediaCollection(Tiding::MEDIA_COLLECTION_NAME);
            $tiding->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Tiding::MEDIA_COLLECTION_NAME);
        }
        return $tiding->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tiding  $tiding
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Tiding $tiding)
    {
        $tiding->delete();

        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  Tiding $tiding
     * @return Application|ResponseFactory|Response
     */
    public function active(Tiding $tiding)
    {
        $tiding->active();
        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  Tiding $tiding
     * @return Application|ResponseFactory|Response
     */
    public function block(Tiding $tiding)
    {
        $tiding->block();
        return $this->success(__('auth.success_operation'));
    }
}
