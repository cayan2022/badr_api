<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Helpers\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Requests\Api\Dashboard\StoreRoleRequest;
use App\Http\Requests\Api\Dashboard\UpdateRoleRequest;
use App\Http\Requests\Api\Dashboard\AssignRoleToUserRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 *
 */
class RoleController extends Controller
{
    use RespondsWithHttpStatus;

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return RoleResource::collection(Role::with(['permissions'=>fn($q)=>$q->select(['id','name','type'])])->latest()->get(['id','name']));
    }
    /**
     *
     * add new Role with selected permissions
     *
     */
    public function store(StoreRoleRequest $request)
    {
        $request->user()->can('create roles');

        $role = Role::create(['name' => $request->name, 'guard_name' => 'api']);

        $role->syncPermissions((array)$request->requested_permissions);

        return $this->success(__('auth.success_operation'));
    }

    /**
     * @param  Role  $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        return response()->json(['data' => [$role->name,$role->permissions]]);
    }

    /**
     * @param  \App\Http\Requests\Api\Dashboard\UpdateRoleRequest  $request
     * @param  Role  $role
     * @return Application|ResponseFactory|Response
     */
    public function update(\App\Http\Requests\Api\Dashboard\UpdateRoleRequest $request,Role $role)
    {
        $request->user()->can('update roles');

        $role->update(['name' => $request->name]);

        $role->syncPermissions((array)$request->requested_permissions);

        return $this->success(__('auth.success_operation'));
    }

    /**
     *
     * assign role with selected permissions to specific user
     *
     */
    public function assign(AssignRoleToUserRequest $request)
    {
        $role = Role::query()->findOrFail($request->role_id);

        $user = User::query()->findOrFail($request->user_id);

        $user->syncRoles([$role]);

        return $this->success(__('auth.success_operation'));
    }
}
