<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Services\Impl;

use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPostPullEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPostPushEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPrePullEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPrePushEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationUpdateEvent;
use OpenClassrooms\Bundle\OneSkyBundle\Model\FileFactory;
use OpenClassrooms\Bundle\OneSkyBundle\Services\FileService;
use OpenClassrooms\Bundle\OneSkyBundle\Services\TranslationService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class TranslationServiceImpl implements TranslationService
{
    private EventDispatcherInterface $eventDispatcher;
    private array $filePaths;
    private FileFactory $fileFactory;
    private string $fileFormat;
    private FileService $fileService;
    private array $requestedLocales;
    private string $sourceLocale;

    public function update(array $filePaths = [], array $locales = []): array
    {
        $this->eventDispatcher->dispatch(new TranslationUpdateEvent(), TranslationUpdateEvent::getEventName());

        return [$this->pull($filePaths, $locales), $this->push($filePaths)];
    }

    public function pull(array $filePaths, array $locales = []): array
    {
        $exportFiles = [];
        /** @var SplFileInfo $file */
        foreach ($this->getFiles($filePaths, $this->getSourceLocales()) as $file) {
            foreach ($this->getRequestedLocales($locales) as $locale) {
                $exportFiles[] = $this->fileFactory->createExportFile($file->getRealPath(), $locale);
            }
        }

        $this->eventDispatcher->dispatch(
            new TranslationPrePullEvent($exportFiles),
            TranslationPrePullEvent::getEventName()
        );

        $downloadedFiles = $this->fileService->download($exportFiles);

        $this->eventDispatcher->dispatch(
            new TranslationPostPullEvent($downloadedFiles),
            TranslationPostPullEvent::getEventName()
        );

        return $downloadedFiles;
    }

    private function getFiles(array $filePaths, array $locales): Finder
    {
        return Finder::create()
            ->files()
            ->in($this->getFilePaths($filePaths))
            ->name('*.{'.implode(',', $locales).'}.'.$this->fileFormat)
            ->sortByName();
    }

    /**
     * @return string[]
     */
    private function getFilePaths(array $filePaths): array
    {
        return empty($filePaths) ? $this->filePaths : $filePaths;
    }

    /**
     * @return string[]
     */
    private function getSourceLocales(array $locales = []): array
    {
        return empty($locales) ? [$this->sourceLocale] : $locales;
    }

    /**
     * @return string[]
     */
    private function getRequestedLocales(array $locales): array
    {
        return empty($locales) ? $this->requestedLocales : $locales;
    }

    public function push(array $filePaths, array $locales = []): array
    {
        $uploadFiles = [];
        /* @var SplFileInfo $file */
        foreach ($this->getSourceLocales($locales) as $locale) {
            foreach ($this->getFiles($filePaths, [$locale]) as $file) {
                $uploadFiles[] = $this->fileFactory->createUploadFile($file->getRealPath(), $locale);
            }
        }

        $this->eventDispatcher->dispatch(
            new TranslationPrePushEvent($uploadFiles),
            TranslationPrePushEvent::getEventName()
        );

        $uploadedFiles = $this->fileService->upload($uploadFiles);

        $this->eventDispatcher->dispatch(
            new TranslationPostPushEvent($uploadedFiles),
            TranslationPostPushEvent::getEventName()
        );

        return $uploadedFiles;
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function setFileFactory(FileFactory $fileFactory): void
    {
        $this->fileFactory = $fileFactory;
    }

    public function setFileFormat($fileFormat): void
    {
        $this->fileFormat = $fileFormat;
    }

    public function setFilePaths(array $filePaths): void
    {
        $this->filePaths = $filePaths;
    }

    public function setFileService(FileService $fileService): void
    {
        $this->fileService = $fileService;
    }

    public function setRequestedLocales(array $requestedLocales): void
    {
        $this->requestedLocales = $requestedLocales;
    }

    public function setSourceLocale($sourceLocale): void
    {
        $this->sourceLocale = $sourceLocale;
    }
}
