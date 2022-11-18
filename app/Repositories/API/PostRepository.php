<?php
namespace App\Repositories\API;
use App\Models\Posts;


class PostRepository
{
    protected $posts;
    public function __construct(Posts $posts)
    {
        $this->posts = $posts;
    }

    public function getAllPosts($keywords = null,$limit)
    {
        // function: search + paginate
        $posts = $this->posts->select('*');

        $orderBy = 'created_at';
        $orderType = 'desc';
        $posts = $posts->orderBy($orderBy, $orderType);

        if (!empty($keywords)) {
            $posts = $posts->where(function ($query) use ($keywords) {
                $query->orWhere('title', 'like', "%{$keywords}%");
            });
        }

        if (!empty($limit)) {
            $posts = $posts->paginate($limit);
        } else {
            $posts = $posts->paginate(PER_PAGE);
        }

        return $posts;
    }

    public function savePostData($data){
        $result = $this->posts->create($data);
        return $result;
    }

    public function getAllPost(){
        $select = $this->posts->all();
        return $select;
    }

    public function getById($post){
        return $this->posts->find($post);
    }

    public function updateDataPost($data, $post){
        return $this->posts->findOrFail($post)->update($data);
    }

    public function delete($id){
        return true;
        // return $this->posts->findOrFail($id)->delete();
    }

}
