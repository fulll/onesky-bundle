<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use Symfony\Contracts\EventDispatcher\Event;

class TranslationUploadTranslationEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.upload_translation';

    private UploadFile $uploadFile;

    public function __construct(UploadFile $uploadFile)
    {
        $this->uploadFile = $uploadFile;
    }

    public static function getEventName(): string
    {
        return self::EVENT_NAME;
    }

    public function getUploadFile(): UploadFile
    {
        return $this->uploadFile;
    }
}
