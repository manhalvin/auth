<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RoleRequest;
use App\Http\Requests\API\UpdateRoleRequest;
use App\Http\Resources\Admin\RoleResource;
use App\Services\API\GroupPermissionService;
use App\Services\API\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected $roleService, $groupPermissionService;
    public function __construct(RoleService $roleService, GroupPermissionService $groupPermissionService)
    {
        $this->roleService = $roleService;
        $this->groupPermissionService = $groupPermissionService;
    }
    function index(Request $request) {
        $search = '';
        if ($request->has('search')) {
            $search = $request->input('search');
        }
        $result = RoleResource::collection($this->roleService->searchRole($search));
        return sendSuccess($result, 'Fetch Data Role Success');
    }

    public function create()
    {
        return sendSuccess([], 'View: Add Role');
    }

    public function store(RoleRequest $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $permission_id = $request->input('permission_id');
        return $this->roleService->handleAdd($name, $description, $permission_id);
    }

    public function show($role)
    {
        $groupPermissions = $this->groupPermissionService->getAll();
        $role = $this->roleService->getId($role);
        $permissionsChecked = $role->permissions;
        $result = [
            'groupPermissions' => $groupPermissions,
            'role' => $role,
            'permissionsChecked' => $permissionsChecked
        ];
        return sendSuccess($result,'Show Data Success');
    }

    public function edit($role)
    {
        $groupPermissions = $this->groupPermissionService->getAll();
        $role = $this->roleService->getId($role);
        $permissionsChecked = $role->permissions;
        $result = [
            'groupPermissions' => $groupPermissions,
            'role' => $role,
            'permissionsChecked' => $permissionsChecked
        ];
        return sendSuccess($result,'Edit Data Success');
    }

    function update($role, UpdateRoleRequest $request) {
        $name = $request->input('name');
        $description = $request->input('description');
        $permission_id = $request->input('permission_id');
        return $this->roleService->handleUpdate($role,$name, $description, $permission_id);
    }

    public function delete($role){
        $this->roleService->delete($role);
        return sendSuccess([],'Delete Data Success');
    }
}
