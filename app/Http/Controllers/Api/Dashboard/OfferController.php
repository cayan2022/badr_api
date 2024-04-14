<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreOfferRequest;
use App\Http\Requests\Api\Dashboard\UpdateOfferRequest;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return OfferResource::collection(Offer::filter()->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOfferRequest  $request
     * @return Response
     */
    public function store(StoreOfferRequest $request)
    {
        $offer=Offer::create($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $offer->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Offer::MEDIA_COLLECTION_NAME);
        }
        return $offer->getResource();

    }

    /**
     * Display the specified resource.
     *
     * @param  Offer  $offer
     * @return OfferResource
     */
    public function show(Offer $offer)
    {
        return $offer->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateOfferRequest  $request
     * @param  Offer  $offer
     * @return OfferResource
     */
    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $offer->update($request->validated());

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $offer->clearMediaCollection(Offer::MEDIA_COLLECTION_NAME);
            $offer->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Offer::MEDIA_COLLECTION_NAME);
        }

        return $offer->getResource();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Offer  $offer
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  Offer  $offer
     * @return Application|ResponseFactory|Response
     */
    public function block(Offer $offer)
    {
        $offer->block();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  Offer  $offer
     * @return Application|ResponseFactory|Response
     */
    public function active(Offer $offer)
    {
        $offer->active();
        return $this->success(__('auth.success_operation'));
    }
}
