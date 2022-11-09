<?php
namespace App\Services\API;

use App\Http\Resources\userResoure;
use Illuminate\Support\Facades\Auth;
use App\Repositories\API\userRepository;
use Illuminate\Support\Facades\Hash;

class UerService{

    protected $userRepository;
    public function __construct(userRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getById($user){
        return $this->userRepository->getByIdUser($user);
    }


    public function getAllUsers($filters,$keywords,$sortByArr,$perPage){
        $select = $this->userRepository->getAllUsers($filters,$keywords,$sortByArr,$perPage);
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
            return sendSuccess(new userResoure($data), 'Fetch Data Success !');
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
            return sendSuccess(new userResoure($data), 'Fetch Data Success !');
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
}

