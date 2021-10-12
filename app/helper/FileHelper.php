<?php

namespace App\Helper;

class FileHelper
{
    private static string $path = __DIR__ . "/../../assets/media/";

    public function createDirectory(string $directoryName)
    {
        if(!file_exists(self::$path . $directoryName)) {
            @mkdir(self::$path . $directoryName, 0777);
        }
    }

    public function deleteFile(string $fileName, string $folderName)
    {
        if(file_exists(self::$path . $folderName . "/" . $fileName)) {
            @unlink(self::$path . $folderName . "/" . $fileName);
        }
    }
}