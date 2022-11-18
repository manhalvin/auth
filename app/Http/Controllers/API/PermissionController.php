<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PermissionRequest;
use App\Http\Requests\API\UpdatePermissionRequest;
use App\Http\Resources\API\PermissionResource;
use App\Services\API\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    protected $permissionService;
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index(){
        $permissions = PermissionResource::collection($this->permissionService->getList());
        return sendSuccess($permissions,'Fetch Data Success');
    }
    public function create(){
        return sendSuccess([],'View: Add Permission Success');
    }

    public function store(PermissionRequest $request){
        $name = $request->input('name');
        $title = $request->input('title');
        $group_permission_id = $request->input('group_permission_id');
        $dataInsert = [
            'name' => $name,
            'title' => $title,
            'group_permission_id' =>  $group_permission_id
        ];
        $this->permissionService->handleAdd( $dataInsert );
        return sendSuccess('','Add Permission Success');
    }

    public function update($id,UpdatePermissionRequest $request){
        $name = $request->input('name');
        $title = $request->input('title');
        $group_permission_id = $request->input('group_permission_id');
        $this->permissionService->update($id,$name,$title,$group_permission_id);
        return sendSuccess([],'Update Permission Success');
    }

    public function show($id){
        $result = new PermissionResource($this->permissionService->getId($id));
        return sendSuccess($result,'Fetch Permission Success');
    }

    public function edit($id){
        $result = new PermissionResource($this->permissionService->getId($id));
        return sendSuccess($result,'Edit Permission Success');
    }

    public function delete($id){
        $this->permissionService->delete($id);
        return sendSuccess([],'Delete Permission Success');

    }
}
