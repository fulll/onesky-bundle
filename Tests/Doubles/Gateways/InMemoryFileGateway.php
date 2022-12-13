<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Gateways;

use OpenClassrooms\Bundle\OneSkyBundle\Gateways\FileGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;

class InMemoryFileGateway implements FileGateway
{
    /**
     * @var ExportFile[]
     */
    public static array $downloadedFiles = [];

    /**
     * @var UploadFile[]
     */
    public static array $uploadedFiles = [];

    public function __construct()
    {
        self::$downloadedFiles = [];
        self::$uploadedFiles = [];
    }

    public function downloadTranslations(array $files): array
    {
        self::$downloadedFiles = $files;
        return [];
    }

    public function uploadTranslations(array $files): array
    {
        self::$uploadedFiles = $files;
        return [];
    }
}
