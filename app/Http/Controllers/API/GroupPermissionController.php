<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\GroupPermissionRequest;
use App\Http\Requests\API\UpdateGroupPermissionRequest;
use App\Services\API\GroupPermissionService;
use Illuminate\Http\Request;

class GroupPermissionController extends Controller
{

    protected $groupPermissionService;
    public function __construct(GroupPermissionService $groupPermissionService)
    {
        $this->groupPermissionService = $groupPermissionService;
    }

    public function index(){
        $groupPermissions = $this->groupPermissionService->getList();
        return sendSuccess($groupPermissions,'Fetch Data Success');
    }

    public function create(){
        return sendSuccess([],'View: Create Group Permission');
    }

    public function store(GroupPermissionRequest $request){
        $data = $request->all();
        $this->groupPermissionService->handleAdd($data);
        return sendSuccess('','Add Group Permission Success');
    }

    public function update($id,UpdateGroupPermissionRequest $request){
        $name = $request->name;
        $description = $request->description;
        $this->groupPermissionService->update($id,$name,$description);
        return sendSuccess([],'Update Group Permission Success');
    }

    public function show($id){
        $result = $this->groupPermissionService->getId($id);
        return sendSuccess($result,'Show Group Permission Success');
    }

    public function edit($id){
        $result = $this->groupPermissionService->getId($id);
        return sendSuccess($result,'Fetch Group Permission Success');
    }

    public function delete($id){
        $this->groupPermissionService->delete($id);
        return sendSuccess([],'Delete Group Permission Success');

    }
}
