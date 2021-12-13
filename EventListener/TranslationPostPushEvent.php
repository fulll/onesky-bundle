<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TranslationPostPushEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.post_push';

    /**
     * @var UploadFile[]
     */
    private $uploadedFiles;

    /**
     * @param UploadFile[] $uploadedFiles
     */
    public function __construct(array $uploadedFiles = [])
    {
        $this->uploadedFiles = $uploadedFiles;
    }

    /**
     * @return string
     */
    public static function getEventName()
    {
        return self::EVENT_NAME;
    }

    /**
     * @return array|\OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile[]
     */
    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }
}
