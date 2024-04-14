<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Branch;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchResource;
use App\Helpers\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Requests\Api\Dashboard\StoreBranchRequest;
use App\Http\Requests\Api\Dashboard\UpdateBranchRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BranchController extends Controller
{

    use RespondsWithHttpStatus;

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return BranchResource::collection(Branch::filter()->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBranchRequest  $request
     * @return BranchResource
     */
    public function store(StoreBranchRequest $request): BranchResource
    {
        $branch = Branch::create($request->validated());

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $branch->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Branch::MEDIA_COLLECTION_NAME);
        }
        return $branch->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  Branch  $branch
     * @return BranchResource
     */
    public function show(Branch $branch): BranchResource
    {
        return $branch->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateBranchRequest  $request
     * @param  Branch  $branch
     * @return BranchResource
     */
    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $branch->update($request->validated());

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $branch->clearMediaCollection(Branch::MEDIA_COLLECTION_NAME);
            $branch->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Branch::MEDIA_COLLECTION_NAME);
        }

        return $branch->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Branch  $branch
     * @return Response
     */
    public function destroy(Branch $branch): Response
    {
        $branch->delete();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  Branch  $branch
     * @return Application|ResponseFactory|Response
     */
    public function block(Branch $branch)
    {
        $branch->block();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  Branch  $branch
     * @return Application|ResponseFactory|Response
     */
    public function active(Branch $branch)
    {
        $branch->active();
        return $this->success(__('auth.success_operation'));
    }
}
