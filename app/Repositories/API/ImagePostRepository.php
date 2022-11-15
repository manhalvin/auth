<?php
namespace App\Repositories\API;
use App\Models\Posts;


class ImagePostRepository
{
    protected $posts;
    const _PER_PAGE = 5;
    public function __construct(Posts $posts)
    {
        $this->posts = $posts;
    }

    public function savePostData($data){
        return $this->posts->create($data);
    }

    public function updatePostData($post,$data){
        return $this->posts->findOrFail($post)->update($data);
    }

    public function getId($id){
        return $this->posts->findOrFail($id);
    }

    public function handleDelete($id){
        return $this->posts->findOrFail($id)->delete($id);
    }

}
