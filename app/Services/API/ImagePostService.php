<?php
namespace App\Services\API;

use App\Repositories\API\ImagePostRepository;
use Illuminate\Support\Facades\File;

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
        if (!empty($result->thumbnail)) {
            if (File::exists(public_path($result->thumbnail))) {
                unlink($result->thumbnail);
            }
        }
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
        return $this->imagePostRepository->updatePostData($post, $dataInput);
    }

    public function handleDelete($id){
        $result = $this->imagePostRepository->getId($id);
        if (!empty($result->thumbnail)) {
            if (File::exists(public_path($result->thumbnail))) {
                unlink($result->thumbnail);
            }
        }
        return $this->imagePostRepository->handleDelete($id);
    }
}
