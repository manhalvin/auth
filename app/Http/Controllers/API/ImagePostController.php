<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\EditImageRequest;
use App\Http\Requests\API\ImagePostRequest;
use App\Services\API\ImagePostService;
use Illuminate\Http\Request;

class ImagePostController extends Controller
{

    protected $imagePostService;
    public function __construct(ImagePostService $imagePostService)
    {
        $this->imagePostService = $imagePostService;
    }
    public function imageStore(ImagePostRequest $request){

        $thumbnail = $request->file('thumbnail');
        $dataInput = $request->all();
        $hasFile = $request->hasFile('thumbnail');
        $this->imagePostService->handLeAdd($thumbnail,$dataInput,$hasFile);
        return sendSuccess([], 'Add Data Post And Upload File Success');
    }

    public function imageEdit($post,EditImageRequest $request){
        $thumbnail = $request->file('thumbnail');
        $dataInput = $request->all();
        $hasFile = $request->hasFile('thumbnail');
        $this->imagePostService->handLeEdit($post,$thumbnail,$dataInput,$hasFile);
        return sendSuccess([], 'Update Data Post And Upload File Success');
    }

    public function imageDelete($post){
        $this->imagePostService->handleDelete($post);
        return sendSuccess([], 'Delete File Success');
    }
}
