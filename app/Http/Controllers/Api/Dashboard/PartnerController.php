<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StorePartnerRequest;
use App\Http\Requests\Api\Dashboard\UpdatePartnerRequest;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
class PartnerController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return PartnerResource::collection(Partner::filter()->latest()->paginate());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePartnerRequest  $request
     * @return Response
     */
    public function store(StorePartnerRequest $request)
    {
        $partner= Partner::create($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $partner->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Partner::MEDIA_COLLECTION_NAME);
        }
        return $partner->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  Partner  $partner
     * @return PartnerResource
     */
    public function show(Partner $partner)
    {
        return $partner->getResource();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePartnerRequest  $request
     * @param  Partner  $partner
     * @return PartnerResource
     */
    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $partner->update($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $partner->clearMediaCollection(Partner::MEDIA_COLLECTION_NAME);
            $partner->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Partner::MEDIA_COLLECTION_NAME);
        }
        return $partner->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Partner $partner
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();

        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  Partner $partner
     * @return Application|ResponseFactory|Response
     */
    public function block(Partner $partner)
    {
        $partner->block();
        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  Partner $partner
     * @return Application|ResponseFactory|Response
     */
    public function active(Partner $partner)
    {
        $partner->active();
        return $this->success(__('auth.success_operation'));
    }
}
