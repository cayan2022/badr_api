<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreTestimonialRequest;
use App\Http\Requests\Api\Dashboard\UpdateTestimonialRequest;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TestimonialController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return TestimonialResource::collection(Testimonial::filter()->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTestimonialRequest  $request
     * @return Response
     */
    public function store(StoreTestimonialRequest $request)
    {
        $testimonial=Testimonial::create($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $testimonial->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Testimonial::MEDIA_COLLECTION_NAME);
        }
        return $testimonial->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  Testimonial  $testimonial
     * @return TestimonialResource
     */
    public function show(Testimonial $testimonial)
    {
        return $testimonial->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTestimonialRequest  $request
     * @param  Testimonial  $testimonial
     * @return TestimonialResource
     */
    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        $testimonial->update($request->validated());

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $testimonial->clearMediaCollection(Testimonial::MEDIA_COLLECTION_NAME);
            $testimonial->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(Testimonial::MEDIA_COLLECTION_NAME);
        }

        return $testimonial->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Testimonial  $testimonial
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  Testimonial $testimonial
     * @return Application|ResponseFactory|Response
     */
    public function block(Testimonial $testimonial)
    {
        $testimonial->block();
        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  Testimonial $testimonial
     * @return Application|ResponseFactory|Response
     */
    public function active(Testimonial $testimonial)
    {
        $testimonial->active();
        return $this->success(__('auth.success_operation'));
    }
}
