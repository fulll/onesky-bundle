<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use Symfony\Contracts\EventDispatcher\Event;

class TranslationPostPushEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.post_push';

    /** @var UploadFile[] */
    private array $uploadedFiles;

    /** @param UploadFile[] $uploadedFiles */
    public function __construct(array $uploadedFiles = [])
    {
        $this->uploadedFiles = $uploadedFiles;
    }

    public static function getEventName(): string
    {
        return self::EVENT_NAME;
    }

    /** @return UploadFile[] */
    public function getUploadedFiles(): array
    {
        return $this->uploadedFiles;
    }
}
