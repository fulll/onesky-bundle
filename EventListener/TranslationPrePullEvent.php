<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TranslationPrePullEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.pre_pull';

    /**
     * @var ExportFile[]
     */
    private $exportFiles;

    /**
     * @param ExportFile[] $exportFiles
     */
    public function __construct(array $exportFiles)
    {
        $this->exportFiles = $exportFiles;
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
    public function getExportFilesCount()
    {
        return \count($this->exportFiles);
    }
}
