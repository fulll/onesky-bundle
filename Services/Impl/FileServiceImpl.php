<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Services\Impl;

use OpenClassrooms\Bundle\OneSkyBundle\Gateways\FileGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use OpenClassrooms\Bundle\OneSkyBundle\Services\FileService;

class FileServiceImpl implements FileService
{
    private FileGateway $fileGateway;

    public function download(array $files): array
    {
        return $this->fileGateway->downloadTranslations($files);
    }

    /**
     * @param UploadFile[] $files
     */
    public function upload(array $files): array
    {
        return $this->fileGateway->uploadTranslations($files);
    }

    public function setFileGateway(FileGateway $fileGateway): void
    {
        $this->fileGateway = $fileGateway;
    }
}
