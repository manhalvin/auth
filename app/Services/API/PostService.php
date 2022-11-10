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

    public function savePostData($data){
        $result = $this->postRepository->savePostData($data);
        return $result;
    }

    public function handleEdit($post){
        $posts = $this->postRepository->getAllPost();
        foreach ($posts as $k => $v) {
            $this->data[$k] = $v->id;
        }
        if (!in_array($post, $this->data)) {
            return sendError('Data post not exit');
        } else {
            $data = $this->postRepository->getById($post);
            return sendSuccess(new postResoure($data), 'Fetch Data Success !');
        }
    }

    public function getById($post){
        return $this->postRepository->getById($post);
    }

    public function updateDataPost($data, $post){
        return $this->postRepository->updateDataPost($data, $post);
    }

    public function handleDelete($post){
        $posts = $this->postRepository->getAllPost();
        foreach ($posts as $k => $v) {
            $this->data[$k] = $v->id;
        }
        if (!in_array($post, $this->data)) {
            return sendError('Data Post Not exit');
        } else {
            $user = Auth::user();
            $post = $this->postRepository->getById($post);
            $data = ['idPost'=>$post->id,'idUserAuth'=>Auth::id(),'idGroupUser'=>Auth::user()->group->id,'nameGroupUser'=>Auth::user()->group->name,'userCreatePostID' => $post->user_id];
            if($user->can('delete',$post)){
                $result = $this->postRepository->delete($post->id);
                if ($result) {
                    return sendSuccess($data, 'Delete Data Post Success !');
                }
                return sendError($data,'Delete Data Not Success');
            }
            return sendError($data,'Prohibited Access');
        }
    }

}

