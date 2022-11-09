<?php
namespace App\Repositories\API;

use App\Models\Groups;
use Illuminate\Support\Facades\Auth;

class GroupRepository{
    protected $groups;
    public function __construct(Groups $groups)
    {
        $this->groups = $groups;
    }

    public function getById($id){
        return $this->groups->findOrFail($id);
    }

    public function getId($role){
        return $this->groups->select('id')->whereIn('id',$role)->pluck('id')->toArray();
    }

    public function getAllListGroup(){
        $select = $this->groups->all();
        return $select;
    }

    public function update($id,$data,$permissions){
        return $this->groups->findOrFail($id)->update(
            [
                'permissions'=>$permissions,
                'name' => $data['name'],
                'user_id' => $data['user_id']
            ]
        );
    }

    public function delete($id){
        return $this->groups->findOrFail($id)->delete();
    }

    public function saveRoleData($data){
        $role = new Groups();
        $role->name = $data['name'];
        $role->permissions = json_encode($data['permissions']);
        $role->user_id = Auth::id();
        $role->save();
        return $role->fresh();
    }

    public function updatePermission($data,$id){
        return $this->groups->findOrFail($id)->update(['permissions'=>$data]);
    }
}
