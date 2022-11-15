<?php
namespace App\Services\API;

use App\Repositories\API\ImagePostRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImagePostService
{

    protected $imagePostRepository;
    public function __construct(ImagePostRepository $imagePostRepository)
    {
        $this->imagePostRepository = $imagePostRepository;
    }

    public function handLeAdd($thumbnail, $dataInput, $hasFile)
    {
        if ($hasFile) {
            // Image Name
            $imageName = $thumbnail->getClientOriginalName();
            // Image Style
            $imageStyle = $thumbnail->getClientOriginalExtension();
            // Image Size
            $imageSize = $thumbnail->getSize();

            $path = $thumbnail->move('image/posts', $imageName);
            $image = 'image/posts/' . $imageName;
            $dataInput['thumbnail'] = $image;

        }
        return $this->imagePostRepository->savePostData($dataInput);
    }

    public function handLeEdit($post, $thumbnail, $dataInput, $hasFile)
    {
        $result = $this->imagePostRepository->getId($post);
        // $file_path = app_path().$result->thumbnail;
        if (!empty($result->thumbnail)) {
            if (File::exists(public_path($result->thumbnail))) {
                unlink($result->thumbnail);
            }
        }
        if ($hasFile) {
            // Image Name
            $imageName = $thumbnail->getClientOriginalName();

            $filename = pathinfo($imageName , PATHINFO_FILENAME).date("YmdHis").'.'.pathinfo($imageName, PATHINFO_EXTENSION);
            // Image Style
            $imageStyle = $thumbnail->getClientOriginalExtension();
            // Image Size
            $imageSize = $thumbnail->getSize();

            $path = $thumbnail->move('image/posts', $filename);
            $image = 'image/posts/' . $filename;
            $dataInput['thumbnail'] = $image;

        }
        return $this->imagePostRepository->updatePostData($post, $dataInput);
    }

    public function handleDelete($id){
        $result = $this->imagePostRepository->getId($id);
        // $file_path = app_path().'image/posts'.$result->thumbnail;
        if (!empty($result->thumbnail)) {
            if (File::exists(public_path($result->thumbnail))) {
                unlink($result->thumbnail);
            }
        }
        return $this->imagePostRepository->handleDelete($id);
    }
}
