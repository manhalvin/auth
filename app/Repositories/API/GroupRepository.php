<?php
namespace App\Repositories\API;

use App\Models\Groups;

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

    public function update($data,$id){
        return $this->groups->findOrFail($id)->update(['permissions'=>$data]);
    }

    public function delete($id){
        return $this->groups->findOrFail($id)->delete();
    }


}
