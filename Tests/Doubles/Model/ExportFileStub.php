<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model;

use OpenClassrooms\Bundle\OneSkyBundle\Model\Impl\ExportFileImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class ExportFileStub extends ExportFileImpl
{
    public const PROJECT_ID = 1;

    public const PROJECT_DIRECTORY = __DIR__.'/../../../';
}
