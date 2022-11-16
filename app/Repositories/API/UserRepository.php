<?php
namespace App\Repositories\API;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllUsers($filters = [], $keywords = null, $sortByArr = null, $perPage = null, $groupIds=null)
    {
        $users = $this->user
            ->select('users.*', 'roles.name as role_name')
            ->join('roles', 'users.role_id', '=', 'roles.id');

        $orderBy = 'users.created_at';
        $orderType = 'desc';
        if (!empty($sortByArr) && is_array($sortByArr)) {
            if (!empty($sortByArr['sortBy']) && !empty($sortByArr['sortType'])) {
                $orderBy = trim($sortByArr['sortBy']);
                $orderType = trim($sortByArr['sortType']);
            }
        }
        $users = $users->orderBy($orderBy, $orderType);

        if (!empty($filters)) {
            $users = $users->where($filters);
        }

        if (!empty($keywords)) {
            $users = $users->where(function ($query) use ($keywords) {
                $query->orWhere('users.email', 'like', "%{$keywords}%")
                    ->orWhere('users.name', 'like', "%{$keywords}%");
            });
        }

        if (!empty($perPage)) {
            if(!empty($groupIds)){
                $users = $users->whereIn('role_id', $groupIds)->paginate($perPage)->withQueryString();
            }else{
                $users = $users->paginate($perPage)->withQueryString();
            }
        } else {
            $users = $users->get();
        }

        return $users;
    }

    public function getByIdUser($user)
    {
        $select = $this->user->find($user);
        return $select;
    }

    public function getById($id)
    {
        return $this->user->find($id);
    }

    public function getAllListUser()
    {
        $select = $this->user->all();
        return $select;
    }

    public function save($data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role_id = $data['role_id'];
        $user->status = $data['status'];
        $user->save();
        return $user->fresh();
    }

    public function update($data, $id)
    {
        return $this->user->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return true;
//        return $this->user->findOrFail($id)->delete();
    }
}
