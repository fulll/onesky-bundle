<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TranslationUploadTranslationEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.upload_translation';

    /**
     * @var UploadFile
     */
    private $uploadFile;

    public function __construct(UploadFile $uploadFile)
    {
        $this->uploadFile = $uploadFile;
    }

    /**
     * @return string
     */
    public static function getEventName()
    {
        return self::EVENT_NAME;
    }

    /**
     * @return UploadFile
     */
    public function getUploadFile()
    {
        return $this->uploadFile;
    }
}
