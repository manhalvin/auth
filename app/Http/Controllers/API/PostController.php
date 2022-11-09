<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\postResoure;
use App\Services\API\postService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $data = array();

    protected $postService;
    const _PER_PAGE = 5;

    public function __construct(postService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $keywords = '';

        if ($request->has('keywords')) {
            $keywords = $request->input('keywords');
        }

        if($request->has('limit')){
            $limit = $request->input('limit');
            $post = $this->postService->getAllPosts($keywords,$limit);
        }else{
            $post = $this->postService->getAllPosts($keywords,self::_PER_PAGE);
        }

        if ($post->count() == 0) {
            return sendError([], 'Data not exist');
        } else {
            $post = postResoure::collection($post);
            return sendSuccess($post, 'Fetch data post success');
        }
    }
}
