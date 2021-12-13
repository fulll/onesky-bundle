<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ExportFileStub2 extends ExportFileStub
{
    public const SOURCE_FILE_PATH = __DIR__.'/../../Fixtures/Resources/translations/subDirectory/messages.en.yml';

    public const REQUESTED_LOCALE = 'fr';

    public function __construct()
    {
        parent::__construct(self::PROJECT_ID, self::SOURCE_FILE_PATH, self::PROJECT_DIRECTORY, self::REQUESTED_LOCALE);
    }
}
