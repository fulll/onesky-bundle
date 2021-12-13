<?php

namespace Services\Impl;

use OpenClassrooms\Bundle\OneSkyBundle\Model\Impl\ExportFileImpl;
use OpenClassrooms\Bundle\OneSkyBundle\Model\Impl\FileFactoryImpl;
use OpenClassrooms\Bundle\OneSkyBundle\Model\Impl\UploadFileImpl;
use OpenClassrooms\Bundle\OneSkyBundle\Services\Impl\TranslationServiceImpl;
use OpenClassrooms\Bundle\OneSkyBundle\Services\TranslationService;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services\FileServiceMock;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TranslationServiceImplTest extends \PHPUnit\Framework\TestCase
{
    public const IS_KEEPING_ALL_STRINGS = false;
    public const FILE_FORMAT = 'yml';
    public const KERNEL_ROOT_DIR = __DIR__.'/../../';
    public const PROJECT_DIRECTORY = __DIR__.'/../../../';
    public const PROJECT_ID = 1;
    public const SOURCE_LOCALE = 'en';

    /**
     * @var TranslationService
     */
    private $service;

    public function testPullWithLocales()
    {
        $this->service->pull([__DIR__.'/../../Fixtures/Resources/translations'], ['es']);
        $this->assertEquals(
            [$this->buildExportFile1es(), $this->buildExportFile2es()],
            FileServiceMock::$downloadedFiles
        );
    }

    /**
     * @return ExportFileImpl
     */
    private function buildExportFile1es()
    {
        return new ExportFileImpl(
            self::PROJECT_ID,
            __DIR__.'/../../Fixtures/Resources/translations/messages.en.yml',
            self::PROJECT_DIRECTORY,
            'es'
        );
    }

    /**
     * @return ExportFileImpl
     */
    private function buildExportFile2es()
    {
        return new ExportFileImpl(
            self::PROJECT_ID,
            __DIR__.'/../../Fixtures/Resources/translations/subDirectory/messages.en.yml',
            self::PROJECT_DIRECTORY,
            'es'
        );
    }

    public function testWithoutFilePathsPull()
    {
        $this->service->pull([]);
        $this->assertEquals(
            [
                $this->buildExportFile1fr(),
                $this->buildExportFile1es(),
                $this->buildExportFile2fr(),
                $this->buildExportFile2es(),
            ],
            FileServiceMock::$downloadedFiles
        );
    }

    /**
     * @return ExportFileImpl
     */
    private function buildExportFile1fr()
    {
        return new ExportFileImpl(
            self::PROJECT_ID,
            __DIR__.'/../../Fixtures/Resources/translations/messages.en.yml',
            self::PROJECT_DIRECTORY,
            'fr'
        );
    }

    /**
     * @return ExportFileImpl
     */
    private function buildExportFile2fr()
    {
        return new ExportFileImpl(
            self::PROJECT_ID,
            __DIR__.'/../../Fixtures/Resources/translations/subDirectory/messages.en.yml',
            self::PROJECT_DIRECTORY,
            'fr'
        );
    }

    public function testPull()
    {
        $this->service->pull([__DIR__.'/../../Fixtures/Resources/translations/subDirectory']);
        $this->assertEquals(
            [
                $this->buildExportFile2fr(),
                $this->buildExportFile2es(),
            ],
            FileServiceMock::$downloadedFiles
        );
    }

    public function testWithoutFilePathPush()
    {
        $this->service->push([]);
        $this->assertEquals([$this->buildUploadFile1(), $this->buildUploadFile2()], FileServiceMock::$uploadedFiles);
    }

    /**
     * @return UploadFileImpl
     */
    private function buildUploadFile1()
    {
        $file = new UploadFileImpl(
            self::PROJECT_ID,
            __DIR__.'/../../Fixtures/Resources/translations/messages.en.yml',
            self::PROJECT_DIRECTORY,
            self::FILE_FORMAT,
            self::SOURCE_LOCALE
        );
        $file->setKeepingAllStrings(self::IS_KEEPING_ALL_STRINGS);

        return $file;
    }

    /**
     * @return UploadFileImpl
     */
    private function buildUploadFile2()
    {
        $file = new UploadFileImpl(
            self::PROJECT_ID,
            __DIR__.'/../../Fixtures/Resources/translations/subDirectory/messages.en.yml',
            self::PROJECT_DIRECTORY,
            self::FILE_FORMAT,
            self::SOURCE_LOCALE
        );
        $file->setKeepingAllStrings(self::IS_KEEPING_ALL_STRINGS);

        return $file;
    }

    public function testPush()
    {
        $this->service->push([__DIR__.'/../../Fixtures/Resources/*']);
        $this->assertEquals([$this->buildUploadFile1(), $this->buildUploadFile2()], FileServiceMock::$uploadedFiles);
    }

    public function testWithLocalesUpdateUpdate()
    {
        $this->service->update([__DIR__.'/../../Fixtures/Resources/'], ['es']);
        $this->assertEquals(
            [$this->buildExportFile1es(), $this->buildExportFile2es()],
            FileServiceMock::$downloadedFiles
        );
        $this->assertEquals([$this->buildUploadFile1(), $this->buildUploadFile2()], FileServiceMock::$uploadedFiles);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->service = new TranslationServiceImpl();
        $fileFactory = new FileFactoryImpl();
        $fileFactory->setKeepingAllStrings(self::IS_KEEPING_ALL_STRINGS);
        $fileFactory->setFileFormat(self::FILE_FORMAT);
        $fileFactory->setKernelRootDir(self::KERNEL_ROOT_DIR);
        $fileFactory->setProjectId(self::PROJECT_ID);
        $fileFactory->setSourceLocale(self::SOURCE_LOCALE);
        $this->service->setEventDispatcher(new EventDispatcher());
        $this->service->setFileFactory($fileFactory);
        $this->service->setFileFormat(self::FILE_FORMAT);
        $this->service->setFilePaths([__DIR__.'/../../Fixtures/Resources/*']);
        $this->service->setFileService(new FileServiceMock());
        $this->service->setRequestedLocales(['fr', 'es']);
        $this->service->setSourceLocale(self::SOURCE_LOCALE);
    }
}
