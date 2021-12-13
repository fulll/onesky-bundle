<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TranslationPrePushEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.pre_push';

    /**
     * @var UploadFile[]
     */
    private $uploadFiles;

    /**
     * @param UploadFile[] $uploadFiles
     */
    public function __construct(array $uploadFiles)
    {
        $this->uploadFiles = $uploadFiles;
    }

    /**
     * @return string
     */
    public static function getEventName()
    {
        return self::EVENT_NAME;
    }

    /**
     * @return int
     */
    public function getUploadFilesCount()
    {
        return \count($this->uploadFiles);
    }
}
