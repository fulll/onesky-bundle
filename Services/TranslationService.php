<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Services;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;

interface TranslationService
{
    /**
     * @param string[] $filePaths
     * @param string[] $locales
     *
     * @return ExportFile[] $files
     */
    public function pull(array $filePaths, array $locales = []): array;

    /**
     * @param string[] $filePaths
     *
     * @return UploadFile[] $files
     */
    public function push(array $filePaths, array $locales = []): array;

    /**
     * @param string[] $filePaths
     *
     * @return ExportFile[]|UploadFile[]
     */
    public function update(array $filePaths, array $locales = []): array;
}
