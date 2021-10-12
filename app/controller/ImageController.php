<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\FileHelper;

class ImageController extends DefaultController
{
    public function erase($data)
    {
        $imgName = $data["imgName"];
        $folderName = $data["folderName"];
        $fileHelper = new FileHelper();
        $fileHelper->deleteFile($imgName, $folderName);
        echo json_encode(["status" => 200]);
    }
}