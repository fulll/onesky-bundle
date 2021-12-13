<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TranslationDownloadTranslationEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.download_translation';

    /**
     * @var ExportFile
     */
    private $exportFile;

    public function __construct(ExportFile $exportFile)
    {
        $this->exportFile = $exportFile;
    }

    /**
     * @return string
     */
    public static function getEventName()
    {
        return self::EVENT_NAME;
    }

    /**
     * @return \OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile
     */
    public function getExportFile()
    {
        return $this->exportFile;
    }
}
