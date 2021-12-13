<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model;

use OpenClassrooms\Bundle\OneSkyBundle\Model\Impl\UploadFileImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class UploadFileStub extends UploadFileImpl
{
    public const FILE_FORMAT = 'yaml';

    public const PROJECT_DIRECTORY = __DIR__.'/../../../';

    public const PROJECT_ID = 1;

    public const SOURCE_LOCALE = 'en';

    /**
     * @return string
     */
    public function getFormattedFilePath()
    {
        return sys_get_temp_dir().'/'.$this->getEncodedSourceFileName();
    }
}
