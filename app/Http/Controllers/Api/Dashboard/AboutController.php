<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreAboutRequest;
use App\Http\Requests\Api\Dashboard\UpdateAboutRequest;
use App\Http\Resources\AboutResource;
use App\Models\About;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

class AboutController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return AboutResource::collection(About::filter()->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAboutRequest  $request
     * @return Response
     */
    public function store(StoreAboutRequest $request)
    {
        $about = About::create($request->validated());
        return $about->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  About  $about
     * @return AboutResource
     */
    public function show(About $about)
    {
        return  $about->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAboutRequest  $request
     * @param  About  $about
     * @return AboutResource
     */
    public function update(UpdateAboutRequest $request, About $about)
    {
        $about->update($request->validated());
        return $about->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  About  $about
     * @return Response
     */
    public function destroy(About $about)
    {
        $about->delete();

        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  About $about
     * @return Application|ResponseFactory|Response
     */
    public function block(About $about)
    {
        $about->block();
        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  About $about
     * @return Application|ResponseFactory|Response
     */
    public function active(About $about)
    {
        $about->active();
        return $this->success(__('auth.success_operation'));
    }
}
