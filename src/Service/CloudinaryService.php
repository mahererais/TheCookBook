<?php

namespace App\Service;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Format;
use Cloudinary\Transformation\Resize;
use Cloudinary\Configuration\Configuration;


class CloudinaryService
{
       
    private $apiSecret;
    private $apiMyKey;
    private $apiCloud;

    public function __construct(string $apiSecret, string $apiMyKey, string $apiCloud)
    {
        // Configuration::instance([
        // 'cloud' => [
        //     'cloud_name' => $apiCloud, 
        //     'api_key' => $apiMyKey, 
        //     'api_secret' => $apiSecret],
        //     'url' => [ 
        //         'secure' => true
        //         ]
        //     ]
        // );

        $this->apiMyKey = $apiMyKey;
        $this->apiSecret = $apiSecret;
        $this->apiCloud = $apiCloud;
    }


    public function upload()
    {
        // Upload the image
        // $upload = new UploadApi();
        // $cloudinary = new Cloudinary();
        // $cloudinary->uploadApi->upload('assets/images/user_profile_default.png');

        // echo '<pre>';
        // echo json_encode(
        //     $upload->upload('https://res.cloudinary.com/demo/image/upload/flower.jpg', [
        //         'public_id' => 'flower_sample',
        //         'use_filename' => TRUE,
        //         'overwrite' => TRUE]),
        //     JSON_PRETTY_PRINT
        // );
        // echo '</pre>';
        // dd($cloudinary);
    }
}