<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Services;

use OpenClassrooms\Bundle\OneSkyBundle\Services\Impl\LanguageServiceImpl;
use OpenClassrooms\Bundle\OneSkyBundle\Services\LanguageService;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Gateways\InMemoryLanguageGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\LanguageStub1;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\LanguageStub2;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class LanguageServiceImplTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var LanguageService
     */
    private $service;

    public function testWithoutLocalesGetLanguage()
    {
        $languages = $this->service->getLanguages();
        $this->assertEquals([new LanguageStub2()], $languages);
    }

    public function testGetLanguage()
    {
        $languages = $this->service->getLanguages([LanguageStub1::LOCALE, LanguageStub2::LOCALE]);
        $this->assertEquals([new LanguageStub1(), new LanguageStub2()], $languages);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->service = new LanguageServiceImpl();
        $this->service->setLanguageGateway(
            new InMemoryLanguageGateway(
                [LanguageStub1::LOCALE => new LanguageStub1(), LanguageStub2::LOCALE => new LanguageStub2()]
            )
        );
        $this->service->setRequestedLocales(['ja']);
    }
}
