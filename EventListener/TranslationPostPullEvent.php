<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\EventListener;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use Symfony\Contracts\EventDispatcher\Event;

class TranslationPostPullEvent extends Event
{
    public const EVENT_NAME = 'openclassrooms.onesky.event.post_pull';

    /** @var ExportFile[] */
    private array $downloadedFiles;

    /** @param ExportFile[] $downloadedFiles */
    public function __construct(array $downloadedFiles = [])
    {
        $this->downloadedFiles = $downloadedFiles;
    }

    public static function getEventName(): string
    {
        return self::EVENT_NAME;
    }

    /** @return ExportFile[] */
    public function getDownloadedFiles(): array
    {
        return $this->downloadedFiles;
    }
}
