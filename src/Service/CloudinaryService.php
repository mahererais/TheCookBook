<?php

namespace App\Service;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Format;
use Cloudinary\Transformation\Resize;

class CloudinaryService
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }


    public function upload(Cloudinary $cloudinary)
    {
        // Upload the image
        // $upload = new UploadApi();
        $cloudinary = new Cloudinary();
        $cloudinary->uploadApi->upload('my_image.jpg');
        // echo '<pre>';
        // echo json_encode(
        //     $upload->upload('https://res.cloudinary.com/demo/image/upload/flower.jpg', [
        //         'public_id' => 'flower_sample',
        //         'use_filename' => TRUE,
        //         'overwrite' => TRUE]),
        //     JSON_PRETTY_PRINT
        // );
        // echo '</pre>';
        dd($cloudinary);
    }
}