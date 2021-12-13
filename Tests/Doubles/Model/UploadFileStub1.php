<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UploadFileStub1 extends UploadFileStub
{
    public const IS_KEEPING_ALL_STRINGS = true;

    public const SOURCE_FILE_PATH = __DIR__.'/../../Fixtures/Resources/translations/messages.en.yml';

    protected $isKeepingAllStrings = self::IS_KEEPING_ALL_STRINGS;

    public function __construct()
    {
        parent::__construct(
            self::PROJECT_ID,
            self::SOURCE_FILE_PATH,
            self::PROJECT_DIRECTORY,
            self::FILE_FORMAT,
            self::SOURCE_LOCALE
        );
    }
}
