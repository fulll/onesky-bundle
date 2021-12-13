<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Gateways;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface FileGateway
{
    public const UPLOAD_METHOD = 'upload';

    public const DOWNLOAD_METHOD = 'export';

    /**
     * @param ExportFile[] $files
     *
     * @return ExportFile[] $files
     */
    public function downloadTranslations(array $files);

    /**
     * @param UploadFile[] $files
     *
     * @return UploadFile[] $files
     */
    public function uploadTranslations(array $files);
}
