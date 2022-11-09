<?php
namespace App\Services\API;

use App\Http\Resources\postResoure;
use App\Repositories\API\postRepository;
use Illuminate\Support\Facades\Auth;

class PostService{

    protected $postRepository;
    public function __construct(postRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAllPosts($keywords,$limit){
        $select = $this->postRepository->getAllPosts($keywords,$limit);
        return $select;
    }



}

