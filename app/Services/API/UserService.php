<?php
namespace App\Services\API;

use App\Http\Resources\API\userResource;
use App\Repositories\API\GroupRepository;
use App\Repositories\API\PostRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\API\userRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class UserService{

    protected $userRepository,$postRepository;
    public function __construct(userRepository $userRepository,GroupRepository $groupRepository)
    {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
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
        // return $this->userRepository->update($data,$id);
        return $this->userRepository->update(
            [
                'password'=> bcrypt($data['password']),
                'name' => $data['name'],
                'group_id' => $data['group_id'],
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
            $user = Auth::user();
            $user = $this->userRepository->getById($user);
            if($user->can('delete',$user)){
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

