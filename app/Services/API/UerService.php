<?php
namespace App\Services\API;

use App\Http\Resources\userResoure;
use Illuminate\Support\Facades\Auth;
use App\Repositories\API\userRepository;

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

}

