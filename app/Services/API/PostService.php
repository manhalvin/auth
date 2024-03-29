<?php
namespace App\Services\API;

use App\Http\Resources\PostResource;
use App\Repositories\API\postRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;

class PostService{

    protected $postRepository;

    public function __construct(postRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function handleIndex($request){
        $keywords = '';

        if ($request->has('keywords')) {
            $keywords = $request->input('keywords');
        }

        if ($request->has('limit')) {
            $limit = $request->input('limit');
            $post = $this->getAllPosts($keywords, $limit);
        } else {
            $post = $this->getAllPosts($keywords, PER_PAGE);
        }

        if ($post->count() == 0) {
            return sendError([], 'Data not exist');
        } else {
            $post = PostResource::collection($post);
            return sendSuccess($post, 'Fetch data post success');
        }
    }

    public function savePostData($request){
        $data = $request->all();
        $hasFile = $request->hasFile('thumbnail');
        $thumbnail = $request->file('thumbnail');
        if ($hasFile) {
            $imageName = $thumbnail->getClientOriginalName();

            $thumbnail->move('image/posts', $imageName);
            $image = 'image/posts/' . $imageName;
            $data['thumbnail'] = $image;

        }
        $result = $this->postRepository->savePostData($data);
        $result = new PostResource($result);
        return sendSuccess($result, 'Inserted Data Success !');
    }

    public function getAllPosts($keywords,$limit){
        $select = $this->postRepository->getAllPosts($keywords,$limit);
        return $select;
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
            return sendSuccess(new PostResource($data), 'Fetch Data Success !');
        }
    }

    public function getById($post){
        return $this->postRepository->getById($post);
    }

    public function updateDataPost($request, $post){
        $result = $this->postRepository->getById($post);
        $hasFile = $request->hasFile('thumbnail');
        $thumbnail = $request->file('thumbnail');
        $data = $request->all();
        if (!empty($result->thumbnail)) {
            if (File::exists(public_path($result->thumbnail))) {
                unlink($result->thumbnail);
            }
        }
        if ($hasFile) {

            $imageName = $thumbnail->getClientOriginalName();

            $thumbnail->move('image/posts', $imageName);
            $image = 'image/posts/' . $imageName;
            $data['thumbnail'] = $image;

        }
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

            if($user->can('delete',$post)){
                $result = $this->postRepository->delete($post->id);
                if ($result) {
                    return sendSuccess([], 'Delete Data Post Success !');
                }
                return sendError([],'Delete Data Not Success');
            }
            return sendError([],'Prohibited Access');
        }
    }

}

