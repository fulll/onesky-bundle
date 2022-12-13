<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Services\Impl;

use OpenClassrooms\Bundle\OneSkyBundle\Services\FileService;
use OpenClassrooms\Bundle\OneSkyBundle\Services\Impl\FileServiceImpl;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Gateways\InMemoryFileGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\ExportFileStub1;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\ExportFileStub2;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\UploadFileStub1;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\UploadFileStub2;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class FileServiceImplTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var FileService
     */
    private $service;

    public function testNoFileUploadDonTUpload()
    {
        $this->service->upload([]);
        $this->assertEmpty(InMemoryFileGateway::$uploadedFiles);
    }

    public function testOneFileUploadUpload()
    {
        $files = [new UploadFileStub1()];
        $this->service->upload($files);
        $this->assertEquals(InMemoryFileGateway::$uploadedFiles, $files);
    }

    public function testManyFilesUploadUpload()
    {
        $files = [new UploadFileStub1(), new UploadFileStub2()];
        $this->service->upload($files);
        $this->assertEquals(InMemoryFileGateway::$uploadedFiles, $files);
    }

    public function testNoFileDownloadDonTDownload()
    {
        $this->service->download([]);
        $this->assertEmpty(InMemoryFileGateway::$downloadedFiles);
    }

    public function testOneFileDownloadDownload()
    {
        $files = [new ExportFileStub1()];
        $this->service->download($files);
        $this->assertEquals(InMemoryFileGateway::$downloadedFiles, $files);
    }

    public function testManyFilesDownloadDownload()
    {
        $files = [new ExportFileStub1(), new ExportFileStub2()];
        $this->service->download($files);
        $this->assertEquals(InMemoryFileGateway::$downloadedFiles, $files);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->service = new FileServiceImpl();
        $this->service->setFileGateway(new InMemoryFileGateway());
    }
}
