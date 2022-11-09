<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\EditPostRequest;
use App\Http\Requests\API\PostRequest;
use App\Http\Resources\postResoure;
use App\Models\Posts;
use App\Services\API\postService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $user = Auth::user();
        if ($user->can('viewAny', Posts::class)) {
            $keywords = '';

            if ($request->has('keywords')) {
                $keywords = $request->input('keywords');
            }

            if ($request->has('limit')) {
                $limit = $request->input('limit');
                $post = $this->postService->getAllPosts($keywords, $limit);
            } else {
                $post = $this->postService->getAllPosts($keywords, self::_PER_PAGE);
            }

            if ($post->count() == 0) {
                return sendError([], 'Data not exist');
            } else {
                $post = postResoure::collection($post);
                return sendSuccess($post, 'Fetch data post success');
            }
        } else {
            return sendError([], 'Prohibited Access');
        }

    }

    public function add()
    {
        if (Auth::user()->can('create', Posts::class)) {
            return sendSuccess([], 'View: Add Post');
        } else {
            return sendError([], 'Prohibited Access');
        }

    }

    public function postAdd(PostRequest $request)
    {
        if (Auth::user()->can('create', Posts::class)) {
            $data = $request->all();
            $result = $this->postService->savePostData($data);
            $result = new postResoure($result);
            return sendSuccess($result, 'Inserted Data Success !');
        } else {
            return sendError([], 'Prohibited Access');
        }

    }

    public function edit($post)
    {
        $result = $this->postService->handleEdit($post);
        $posts = $this->postService->getById($post);
        if ($posts) {
            if (Auth::user()->can('update', $posts)) {
                if ($result) {
                    return $result;
                }
            } else {
                return sendError([], 'Prohibited Access');
            }
        } else {
            return sendError('Data Post Not exit');
        }
    }

    public function show($post)
    {
        $result = $this->postService->handleEdit($post);
        $posts = $this->postService->getById($post);
        if ($posts) {
            if (Auth::user()->can('view', $posts)) {
                if ($result) {
                    return $result;
                }
            } else {
                return sendError([], 'Prohibited Access');
            }
        } else {
            return sendError('Data Post Not exit');
        }
    }

    public function postEdit(EditPostRequest $request, $post)
    {
        $data = $request->all();
        $posts = $this->postService->getById($post);
        if ($posts) {
            if(Auth::user()->can('update',$posts)){
                $this->postService->updateDataPost($data, $post);
                return sendSuccess([], 'Update Data Post Success !');
            }else{
                return sendError([],'Prohibited Access');
            }
        } else {
            return sendError('Data Post Not exit');
        }
    }

    public function delete($post)
    {
        $result = $this->postService->handleDelete($post);
        return $result;
    }
}
