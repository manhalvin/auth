<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\GroupPermissionRequest;
use App\Http\Requests\API\UpdateGroupPermissionRequest;
use App\Services\API\GroupPermissionService;

class AdminGroupPermissionController extends Controller
{

    protected $groupPermissionService;
    public function __construct(GroupPermissionService $groupPermissionService)
    {
        $this->groupPermissionService = $groupPermissionService;
    }

    public function list(){
        $groupPermissions = $this->groupPermissionService->getList();
        return sendSuccess($groupPermissions,'Fetch Data Success');
        // 123
    }

    public function store(GroupPermissionRequest $request){
        $name = $request->name;
        $description = $request->description;
        $dataInsert = [
            'name' => $name,
            'description' => $description,
        ];
        $this->groupPermissionService->handleAdd( $dataInsert );
        return sendSuccess('','Add Group Permission Success');
        // 456
    }

    public function putUpdate($id,UpdateGroupPermissionRequest $request){
        $name = $request->name;
        $description = $request->description;
        $this->groupPermissionService->update($id,$name,$description);
        return sendSuccess('','Update Group Permission Success');
    }

    public function getUpdate($id){
        $result = $this->groupPermissionService->getId($id);
        return sendSuccess($result,'Fetch Group Permission Success');
    }

    public function delete($id){
        $this->groupPermissionService->delete($id);
        return sendSuccess([],'Delete Group Permission Success');

    }
}
