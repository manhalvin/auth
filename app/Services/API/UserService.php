<?php
namespace App\Services\API;

use App\Http\Resources\API\UserResource;
use App\Repositories\API\RoleRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\API\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class UserService{

    protected $userRepository,$roleRepository;
    protected $filters,$group_id,$data = [];
    protected $search = null;

    public function __construct(userRepository $userRepository,RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function handleIndex($request){
        if ($request->has('status')) {
            $status = $request->input('status');
            $status = $status == 'active' ? 1 : 0;
            $this->filters[] = ['users.status', '=', $status];
        }

        if ($request->has('role')){
            $role = $request->input('role');
            if(!empty($role)){
                $role = explode(',',$role);
                $this->group_id = $this->roleRepository->getIdRole($role);
            }
        }

        if ($request->has('search')) {
            $this->search = $request->input('search');
        }

        $sortBy = $request->input('sort-by');
        $sortType = $request->input('sort-type');
        $sortArr = $this->handleSort($sortBy,$sortType);

        $user = $this->getAllUsers($this->filters, $this->search, $sortArr, PER_PAGE,$this->group_id);
        if ($user->count() == 0) {
            return sendError([], 'Data not exist');
        } else {
            $user = UserResource::collection($user);
            return sendSuccess($user, 'Fetch data success');
        }
    }

    public function handleAdd($request){
        $data = $request->all();
        $result = $this->save($data);
        $result = new UserResource($result);
        return sendSuccess($result, 'Inserted Data User Success !');
    }


    public function getById($user){
        return $this->userRepository->getByIdUser($user);
    }


    public function getAllUsers($filters,$keywords,$sortByArr,$perPage,$groupIds){
        $select = $this->userRepository->getAllUsers($filters,$keywords,$sortByArr,$perPage,$groupIds);
        return $select;
    }

    public function handleShow($post){
        $posts = $this->userRepository->getAllListUser();
        foreach ($posts as $k => $v) {
            $this->data[$k] = $v->id;
        }
        if (!in_array($post, $this->data)) {
            return sendError('Data post not exit');
        } else {
            $data = $this->userRepository->getById($post);
            return sendSuccess(new UserResource($data), 'Fetch Data Success !');
        }
    }

    public function save($data){
        $result = $this->userRepository->save($data);
        return $result;
    }

    public function handleEdit($user){
        $users = $this->userRepository->getAllListUser();
        foreach ($users as $k => $v) {
            $this->data[$k] = $v->id;
        }
        if (!in_array($user, $this->data)) {
            return sendError('Data user not exit');
        } else {
            $data = $this->userRepository->getById($user);
            return sendSuccess(new UserResource($data), 'Fetch Data Success !');
        }
    }

    public function updateDataUser($data,$id){
        return $this->userRepository->update(
            [
                'password'=> bcrypt($data['password']),
                'name' => $data['name'],
                'role_id' => $data['role_id'],
                'status' => $data['status'],
                'email' => $data['email']
            ],$id
        );
    }

    public function handleDelete($user){
        $users = $this->userRepository->getAllListUser();
        foreach ($users as $k => $v) {
            $this->data[$k] = $v->id;
        }
        if (!in_array($user, $this->data)) {
            return sendError('Data Post Not exit');
        } else {
            $user = $this->getById($user);
            if(Auth::user()->can('delete',$user)){
                $result = $this->userRepository->delete($user->id);
                if ($result) {
                    return sendSuccess([], 'Delete Data user Success !');
                }
                return sendError([],'Delete Data Not Success');
            }
            return sendError([],'Prohibited Access');
        }
    }

    public function handleSort($sortBy,$sortType){

        $allowSort = ['asc', 'desc'];
        if (!empty($sortType) && in_array($sortType, $allowSort)) {
            $sortType = $sortType == 'desc' ? 'asc' : 'desc';
        } else {
            $sortType = 'asc';
        }

        $sortArr = [
            'sortBy' => $sortBy,
            'sortType' => $sortType,
        ];

        return $sortArr;

    }

}

