<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioCategoryResource;
use App\Models\PortfolioCategory;
use App\Http\Requests\Api\Dashboard\StorePortfolioCategoryRequest;
use App\Http\Requests\Api\Dashboard\UpdatePortfolioCategoryRequest;

class PortfolioCategoryController extends Controller
{
    use RespondsWithHttpStatus;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        return PortfolioCategoryResource::collection(PortfolioCategory::filter()->latest()->paginate());
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
     * @param  \App\Http\Requests\Api\Dashboard\StorePortfolioCategoryRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StorePortfolioCategoryRequest $request)
    {
        $portfolio_category = PortfolioCategory::create($request->validated());
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $portfolio_category->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(PortfolioCategory::MEDIA_COLLECTION_NAME);
        }

        return $portfolio_category->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PortfolioCategory  $portfolio_category
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(PortfolioCategory $portfolio_category)
    {
        return $portfolio_category->getResource();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PortfolioCategory  $portfolio_category
     * @return \Illuminate\Http\Response
     */
    public function edit(PortfolioCategory $portfolio_category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\Dashboard\UpdatePortfolioCategoryRequest  $request
     * @param  \App\Models\PortfolioCategory  $portfolio_category
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(UpdatePortfolioCategoryRequest $request, PortfolioCategory $portfolio_category)
    {
        $portfolio_category->update($request->validated());

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $portfolio_category->clearMediaCollection(PortfolioCategory::MEDIA_COLLECTION_NAME);
            $portfolio_category->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(PortfolioCategory::MEDIA_COLLECTION_NAME);
        }

        return $portfolio_category->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PortfolioCategory  $portfolio_category
     * @return Application|ResponseFactory|Response
     */
    public function destroy(PortfolioCategory $portfolio_category)
    {
        $portfolio_category->delete();

        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  PortfolioCategory  $portfolio_category
     * @return Application|ResponseFactory|Response
     */
    public function block(PortfolioCategory $portfolio_category)
    {
        $portfolio_category->block();

        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  PortfolioCategory  $portfolio_category
     * @return Application|ResponseFactory|Response
     */
    public function active(PortfolioCategory $portfolio_category)
    {
        $portfolio_category->active();

        return $this->success(__('auth.success_operation'));
    }
}