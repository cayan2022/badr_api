<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioResource;
use App\Models\Portfolio;
use App\Http\Requests\Api\Dashboard\StorePortfolioRequest;
use App\Http\Requests\Api\Dashboard\UpdatePortfolioRequest;

class PortfolioController extends Controller
{
    use RespondsWithHttpStatus;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        return PortfolioResource::collection(Portfolio::filter()->latest()->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Dashboard\StorePortfolioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePortfolioRequest $request)
    {
        $portfolio = Portfolio::create($request->validated());
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $portfolio->addMediaFromRequest('logo')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Portfolio::MEDIA_COLLECTION_LOGO_NAME);
        }
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $portfolio->addMediaFromRequest('cover')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Portfolio::MEDIA_COLLECTION_COVER_NAME);
        }

        return $portfolio->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Portfolio $portfolio)
    {
        return $portfolio->getResource();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\Dashboard\UpdatePortfolioRequest  $request
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio)
    {
        $portfolio->update($request->validated());

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $portfolio->clearMediaCollection(Portfolio::MEDIA_COLLECTION_LOGO_NAME);
            $portfolio->addMediaFromRequest('logo')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Portfolio::MEDIA_COLLECTION_LOGO_NAME);
        }

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $portfolio->clearMediaCollection(Portfolio::MEDIA_COLLECTION_COVER_NAME);
            $portfolio->addMediaFromRequest('cover')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Portfolio::MEDIA_COLLECTION_COVER_NAME);
        }

        return $portfolio->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  \App\Models\Portfolio  $portfolio
     * @return Application|ResponseFactory|Response
     */
    public function block(Portfolio $portfolio)
    {
        $portfolio->block();

        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  \App\Models\Portfolio  $portfolio
     * @return Application|ResponseFactory|Response
     */
    public function active(Portfolio $portfolio)
    {
        $portfolio->active();

        return $this->success(__('auth.success_operation'));
    }
}