<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreBlogRequest;
use App\Http\Requests\Api\Dashboard\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class BlogController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return BlogResource::collection(Blog::filter()->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Dashboard\StoreBlogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogRequest $request)
    {
        $blog= Blog::create($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $blog->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Blog::MEDIA_COLLECTION_NAME);
        }
        return $blog->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  Blog  $blog
     * @return BlogResource
     */
    public function show(Blog $blog)
    {
        return $blog->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateBlogRequest  $request
     * @param  Blog  $blog
     * @return BlogResource
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $blog->update($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $blog->clearMediaCollection(Blog::MEDIA_COLLECTION_NAME);
            $blog->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Blog::MEDIA_COLLECTION_NAME);
        }
        return $blog->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Blog  $blog
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  Blog $blog
     * @return Application|ResponseFactory|Response
     */
    public function block(Blog $blog)
    {
        $blog->block();
        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  Blog $blog
     * @return Application|ResponseFactory|Response
     */
    public function active(Blog $blog)
    {
        $blog->active();
        return $this->success(__('auth.success_operation'));
    }
}
