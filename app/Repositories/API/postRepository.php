<?php
namespace App\Repositories\API;

use App\Models\Posts;

class PostRepository
{
    protected $posts;
    const _PER_PAGE = 5;
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
            $posts = $posts->paginate(self::_PER_PAGE);
        }

        return $posts;
    }

}
