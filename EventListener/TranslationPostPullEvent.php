<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TranslationPostPullEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.post_pull';

    /**
     * @var ExportFile[]
     */
    private $downloadedFiles;

    /**
     * @param ExportFile[] $downloadedFiles
     */
    public function __construct(array $downloadedFiles = [])
    {
        $this->downloadedFiles = $downloadedFiles;
    }

    /**
     * @return string
     */
    public static function getEventName()
    {
        return self::EVENT_NAME;
    }

    /**
     * @return \OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile[]
     */
    public function getDownloadedFiles()
    {
        return $this->downloadedFiles;
    }
}
