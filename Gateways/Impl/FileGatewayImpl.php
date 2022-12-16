<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Gateways\Impl;

use Onesky\Api\Client;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationDownloadTranslationEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationUploadTranslationEvent;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\FileGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\InvalidContentException;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\NonExistingTranslationException;
use OpenClassrooms\Bundle\OneSkyBundle\Gateways\ServerException;
use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use Symfony\Component\EventDispatcher\EventDispatcher;

class FileGatewayImpl implements FileGateway
{
    private Client $client;
    private EventDispatcher $eventDispatcher;

    public function downloadTranslations(array $files): array
    {
        $downloadedFiles = [];
        foreach ($files as $file) {
            try {
                $downloadedFiles[] = $this->downloadTranslation($file);
            } catch (NonExistingTranslationException $ne) {
            }
        }

        return $downloadedFiles;
    }

    private function downloadTranslation(ExportFile $file): ExportFile
    {
        $this->eventDispatcher->dispatch(
            new TranslationDownloadTranslationEvent($file),
            TranslationDownloadTranslationEvent::getEventName()
        );
        $downloadedContent = $this->client->translations(self::DOWNLOAD_METHOD, $file->format());
        $this->checkTranslation($downloadedContent, $file);
        file_put_contents($file->getTargetFilePath(), $downloadedContent);

        return $file;
    }

    private function checkTranslation($downloadedContent, ExportFile $file): void
    {
        if (0 === strpos($downloadedContent, '{')) {
            $json = json_decode($downloadedContent, true, 512, \JSON_THROW_ON_ERROR);

            if (null !== $json && \array_key_exists('meta', $json) && 400 === $json['meta']['status']) {
                throw new NonExistingTranslationException($file->getTargetFilePath());
            }

            if (null !== $json && \array_key_exists('meta', $json) && 500 === $json['meta']['status']) {
                throw new ServerException($file->getTargetFilePath());
            }

            throw new InvalidContentException($downloadedContent);
        }
    }

    public function uploadTranslations(array $files): array
    {
        $uploadedFiles = [];
        foreach ($files as $file) {
            $uploadedFiles[] = $this->uploadTranslation($file);
        }

        return $uploadedFiles;
    }

    private function uploadTranslation(UploadFile $file): UploadFile
    {
        $this->eventDispatcher->dispatch(
            new TranslationUploadTranslationEvent($file),
            TranslationUploadTranslationEvent::getEventName()
        );
        $this->client->files(self::UPLOAD_METHOD, $file->format());

        return $file;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function setEventDispatcher(EventDispatcher $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }
}
