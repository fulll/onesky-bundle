<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Services;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;

interface FileService
{
    /**
     * @param ExportFile[] $files
     */
    public function download(array $files): array;

    /**
     * @param UploadFile[] $files
     */
    public function upload(array $files): array;
}
