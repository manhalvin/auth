<?php
namespace App\Services\API;

use App\Http\Resources\groupResource;
use App\Repositories\API\GroupRepository;

class GroupService{

    protected $postRepository;
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function handlePermission($group,$dataPermission,$permissions){
        $groups = $this->groupRepository->getAllListGroup();
        foreach ($groups as $k => $v){
            $this->data[$k] = $v->id;
        }
        if(in_array($group,$this->data)){
            $roleArray = empty($permissions) ? [] : $permissions;
            $roleJson = json_encode($roleArray);
            // Convert Array to JSON -> Save Database
            $result = $this->groupRepository->update($group,$dataPermission,$roleJson);
            if($result){
                $data = [
                    'data' => new groupResource($this->groupRepository->getById($group))
                ];
                return $data;
            }else{
                return sendError([],'Update Failed');
            }

        }


    }

    public function handlePermissionAdvance($group,$role){
        $groups = $this->groupRepository->getAllListGroup();
        foreach ($groups as $k => $v){
            $this->data[$k] = $v->id;
        }
        if(in_array($group,$this->data)){
            $roleArray = empty($role) ? [] : $role;
            $roleJson = json_encode($roleArray);
            // Convert Array to JSON -> Save Database
            $this->groupRepository->updatePermission($roleJson,$group);
            $data = [
                'data' => new groupResource($this->groupRepository->getById($group))
            ];
            return $data;
        }
    }


    public function getAllGroup(){
        return $this->groupRepository->getAllListGroup();
    }

    public function getById($id){
        return $this->groupRepository->getById($id);
    }

    public function saveRoleData($data){
        return $this->groupRepository->saveRoleData($data);
    }

}

