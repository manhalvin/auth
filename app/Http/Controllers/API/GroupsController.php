<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\addGroupRequest;
use App\Http\Requests\API\groupRequest;
use App\Services\API\GroupService;
use Illuminate\Http\Request;
use App\Http\Resources\groupResource;

class GroupsController extends Controller
{
    protected $data = array();

    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }
    public function postPermission($group, groupRequest $request)
    {
        $data = $request->all();
        $permissions = $request->input('permissions');
        $result = $this->groupService->handlePermission($group,$data,$permissions);
        if ($result) {
            return sendSuccess($result, 'Permission Success !');
        } else {
            return sendError('Data not exist !');
        }

    }

    public function permission($group)
    {
        $groups = $this->groupService->getAllGroup();
        foreach ($groups as $k => $v) {
            $this->data[$k] = $v->id;
        }
        if (in_array($group, $this->data)) {
            $result = new groupResource($this->groupService->getById($group));
            return sendSuccess($result, 'Fetch Data Success !');
        } else {
            return sendError('Data not exist !');
        }
    }

    public function add(){
        return sendSuccess([], 'View: Add Groups');
    }

    public function postAdd(addGroupRequest $request){
        $data = $request->all();
        $result = $this->groupService->saveRoleData($data);
        $result = new groupResource($result);
        return sendSuccess($result, 'Inserted Data Success !');
    }

    public function index(){
        $groups = $this->groupService->getAllGroup();
        if ($groups->count() == 0) {
            return sendError([], 'Data not exist');
        } else {
            $group = groupResource::collection($groups);
            return sendSuccess($group, 'Fetch data group success');
        }
    }

    public function permissionAdvance($group, Request $request){
        $role = $request->input('role');
        $result = $this->groupService->handlePermissionAdvance($group,$role);
        if($result){
            return sendSuccess($result, 'Permission Success !');
        }else{
            return sendError('Data not exist !');
        }
    }
}
