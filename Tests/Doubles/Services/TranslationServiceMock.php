<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services;

use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationDownloadTranslationEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPostPullEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPostPushEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPrePullEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPrePushEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationUploadTranslationEvent;
use OpenClassrooms\Bundle\OneSkyBundle\Services\TranslationService;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\ExportFileStub1;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\UploadFileStub1;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TranslationServiceMock implements TranslationService
{
    public static array $pulledFilePaths = [];
    public static bool $pullCalled = false;
    public static array $pushedFilePaths = [];
    public static bool $pushCalled = false;
    public static array $updatedFilePaths = [];
    public static bool $updateCalled = false;
    public static array $locales = [];

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        self::$pulledFilePaths = [];
        self::$pullCalled = false;
        self::$pushedFilePaths = [];
        self::$pushCalled = false;
        self::$updatedFilePaths = [];
        self::$updateCalled = false;
        self::$locales = [];
    }

    public function pull(array $filePaths, array $locales = []): array
    {
        $this->eventDispatcher->dispatch(
            new TranslationPrePullEvent([new ExportFileStub1()]),
            TranslationPrePullEvent::getEventName()
        );
        $this->eventDispatcher->dispatch(
            new TranslationDownloadTranslationEvent(new ExportFileStub1()),
            TranslationDownloadTranslationEvent::getEventName()
        );
        $this->eventDispatcher->dispatch(
            new TranslationPostPullEvent([new ExportFileStub1()]),
            TranslationPostPullEvent::getEventName()
        );
        self::$pullCalled = true;
        self::$pulledFilePaths = $filePaths;
        self::$locales = $locales;

        return [];
    }

    public function push(array $filePaths, array $locales = []): array
    {
        $this->eventDispatcher->dispatch(
            new TranslationPrePushEvent([new UploadFileStub1()]),
            TranslationPrePushEvent::getEventName()
        );
        $this->eventDispatcher->dispatch(
            new TranslationUploadTranslationEvent(new UploadFileStub1()),
            TranslationUploadTranslationEvent::getEventName()
        );
        $this->eventDispatcher->dispatch(
            new TranslationPostPushEvent([new UploadFileStub1()]),
            TranslationPostPushEvent::getEventName()
        );
        self::$pushCalled = true;
        self::$pushedFilePaths = $filePaths;
        self::$locales = $locales;

        return [];
    }

    public function update(array $filePaths = [], array $locales = []): array
    {
        self::$updateCalled = true;
        self::$updatedFilePaths = $filePaths;
        self::$locales = $locales;

        return [];
    }
}
