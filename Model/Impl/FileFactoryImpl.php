<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Model\Impl;

use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\FileFactory;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class FileFactoryImpl implements FileFactory
{
    /**
     * @var string
     */
    private $fileFormat;

    /**
     * @var string
     */
    private $kernelRootDir;

    /**
     * @var int
     */
    private $projectId;

    /**
     * @var string
     */
    private $sourceLocale;

    /**
     * @var bool
     */
    private $isKeepingAllStrings;

    /**
     * @return ExportFile
     */
    public function createExportFile($sourceFilePath, $requestedLocale)
    {
        return new ExportFileImpl($this->projectId, $sourceFilePath, $this->getProjectDirectory(), $requestedLocale);
    }

    /**
     * @return string
     */
    private function getProjectDirectory()
    {
        return $this->kernelRootDir.'/../';
    }

    /**
     * {@inheritdoc}
     */
    public function createUploadFile($filePath, $locale = null)
    {
        $file = new UploadFileImpl(
            $this->projectId,
            $filePath,
            $this->getProjectDirectory(),
            $this->fileFormat,
            empty($locale) ? $this->sourceLocale : $locale
        );

        $file->setKeepingAllStrings($this->isKeepingAllStrings);

        return $file;
    }

    public function setKeepingAllStrings($isKeepingAllStrings)
    {
        $this->isKeepingAllStrings = $isKeepingAllStrings;
    }

    public function setFileFormat($fileFormat)
    {
        $this->fileFormat = $fileFormat;
    }

    public function setKernelRootDir($kernelRootDir)
    {
        $this->kernelRootDir = $kernelRootDir;
    }

    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }

    public function setSourceLocale($sourceLocale)
    {
        $this->sourceLocale = $sourceLocale;
    }
}
