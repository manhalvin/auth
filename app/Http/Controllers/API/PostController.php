<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\EditPostRequest;
use App\Http\Requests\API\PostRequest;
use App\Models\Posts;
use App\Services\API\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {

        $user = Auth::user();
        if ($user->can('viewAny', Posts::class)) {
            return $this->postService->handleIndex($request);
        } else {
            return sendError([], 'Prohibited Access');
        }

    }

    public function create()
    {
        if (Auth::user()->can('create', Posts::class)) {
            return sendSuccess([], 'View: Create Post');
        } else {
            return sendError([], 'Prohibited Access');
        }

    }

    public function store(PostRequest $request)
    {
        if (Auth::user()->can('create', Posts::class)) {
            return $this->postService->savePostData($request);
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
                return $result;
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
                return $result;
            } else {
                return sendError([], 'Prohibited Access');
            }
        } else {
            return sendError('Data Post Not exit');
        }
    }

    public function update(EditPostRequest $request, $post)
    {
        $posts = $this->postService->getById($post);
        if ($posts) {
            if (Auth::user()->can('update', $posts)) {
                $this->postService->updateDataPost($request, $post);
                return sendSuccess([], 'Update Data Post Success !');
            } else {
                return sendError([], 'Prohibited Access');
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
