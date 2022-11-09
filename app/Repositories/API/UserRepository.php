<?php
namespace App\Repositories\API;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllUsers($filters=[],$keywords=null,$sortByArr = null,$perPage=null){
        $users = $this->user
            ->select('users.*','groups.name as group_name')
            ->join('groups','users.group_id','=','groups.id');

        $orderBy = 'users.created_at';
        $orderType = 'desc';
        if(!empty($sortByArr) && is_array($sortByArr)){
            if( !empty($sortByArr['sortBy']) && !empty($sortByArr['sortType']) ){
                $orderBy = trim($sortByArr['sortBy']);
                $orderType = trim($sortByArr['sortType']);
            }
        }
            $users = $users->orderBy($orderBy,$orderType);

            if(!empty($filters)){
                $users = $users->where($filters);
            }

            if(!empty($keywords)){
                $users = $users->where(function ($query) use ($keywords){
                    $query->orWhere('users.email','like',"%{$keywords}%")
                        ->orWhere('users.name','like',"%{$keywords}%");
                });
            }

            if(!empty($perPage)){
                $users = $users->paginate($perPage);
            }else{
                $users = $users->get();
            }

        return $users;
    }

    public function getByIdUser($user){
        $select = $this->user->find($user);
        return $select;
    }

    public function getById($id){
        return $this->user->find($id);
    }

    public function getAllListUser(){
        $select = $this->user->all();
        return $select;
    }

    public function save($data){
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->group_id = $data['group_id'];
        $user->save();
        return $user->fresh();
    }

    public function update($data,$id){
        return $this->user->findOrFail($id)->update($data);
    }

    public function delete($id){
        return $this->user->findOrFail($id)->delete();
    }
}
