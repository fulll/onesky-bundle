<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use OpenClassrooms\Bundle\OneSkyBundle\Services\FileService;

class FileServiceMock implements FileService
{
    public static array $downloadedFiles = [];
    public static array $uploadedFiles = [];

    public function __construct()
    {
        self::$downloadedFiles = [];
        self::$uploadedFiles = [];
    }

    public function download(array $files): array
    {
        self::$downloadedFiles = $files;

        return self::$downloadedFiles;
    }

    public function upload(array $files): array
    {
        self::$uploadedFiles = $files;

        return self::$uploadedFiles;
    }
}
