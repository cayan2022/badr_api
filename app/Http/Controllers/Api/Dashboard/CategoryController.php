<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreCategoryRequest;
use App\Http\Requests\Api\Dashboard\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Helpers\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Response;


class CategoryController extends Controller
{

    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $schema = request()->filled('page') ? 'paginate' : 'get';
        return CategoryResource::collection(Category::filter()->latest()->$schema());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Dashboard\StoreCategoryRequest  $request
     * @return Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $category->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Category::MEDIA_COLLECTION_NAME);
        }
        return $category->getResource();

    }

    /**
     * Display the specified resource.
     *
     * @param  Category  $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return $category->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest  $request
     * @param  Category  $category
     * @return CategoryResource
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $category->clearMediaCollection(Category::MEDIA_COLLECTION_NAME);
            $category->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName) => updateFileName($fileName))
                ->toMediaCollection(Category::MEDIA_COLLECTION_NAME);
        }

        return $category->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category  $category
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  Category  $category
     * @return Application|ResponseFactory|Response
     */
    public function block(Category $category)
    {
        $category->block();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  Category  $category
     * @return Application|ResponseFactory|Response
     */
    public function active(Category $category)
    {
        $category->active();
        return $this->success(__('auth.success_operation'));
    }
}