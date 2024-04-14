<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreCustomerRequest;
use App\Http\Requests\Api\Dashboard\UpdateCustomerRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection(User::whereType(User::PATIENT)->filter()->latest()->paginate());
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function all()
    {
        return UserResource::collection(User::whereType(User::PATIENT)->filter()->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCustomerRequest  $request
     * @return Response
     */
    public function store(StoreCustomerRequest $request)
    {
        $user = User::create($request->validated()+['type'=>User::PATIENT]);

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $user->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(User::MEDIA_COLLECTION_NAME);
        }
        return $user->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return $user->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCustomerRequest  $request
     * @param  User  $user
     * @return UserResource
     */
    public function update(UpdateCustomerRequest $request, User $user)
    {
        $user->update($request->validated());

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $user->clearMediaCollection(User::MEDIA_COLLECTION_NAME);
            $user->addMediaFromRequest('image')
                ->sanitizingFileName(fn($fileName)=>updateFileName($fileName))
                ->toMediaCollection(User::MEDIA_COLLECTION_NAME);
        }

        return $user->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return Application|ResponseFactory|Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  User  $user
     * @return Application|ResponseFactory|Response
     */
    public function block(User $user)
    {
        $user->block();
        $user->tokens()->delete();
        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  User  $user
     * @return Application|ResponseFactory|Response
     */
    public function active(User $user)
    {
        $user->active();
        return $this->success(__('auth.success_operation'));
    }
}
