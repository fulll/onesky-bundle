<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use Symfony\Contracts\EventDispatcher\Event;

class TranslationDownloadTranslationEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.download_translation';

    private ExportFile $exportFile;

    public function __construct(ExportFile $exportFile)
    {
        $this->exportFile = $exportFile;
    }

    public static function getEventName(): string
    {
        return self::EVENT_NAME;
    }

    public function getExportFile(): ExportFile
    {
        return $this->exportFile;
    }
}
