<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Command\CheckTranslationProgressCommand;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\LanguageStub1;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\LanguageStub2;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services\LanguageServiceMock;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CheckTranslationProgressCommandTest extends \PHPUnit\Framework\TestCase
{
    use CommandTestCase;

    /**
     * @var CommandTester
     */
    private $commandTester;

    public function testWithoutLocalesExecute()
    {
        $this->commandTester->execute(['command' => CheckTranslationProgressCommand::COMMAND_NAME]);
        $this->assertEquals([], LanguageServiceMock::$locales);
        $this->assertTrue(LanguageServiceMock::$calledGetLanguages);
    }

    public function testWithLocalesExecute()
    {
        LanguageServiceMock::$languages = [new LanguageStub1(), new LanguageStub2()];
        $exitCode = $this->commandTester->execute(
            ['command' => CheckTranslationProgressCommand::COMMAND_NAME, '--locale' => [LanguageStub2::LOCALE]]
        );
        $this->assertEquals([LanguageStub2::LOCALE], LanguageServiceMock::$locales);
        $this->assertTrue(LanguageServiceMock::$calledGetLanguages);
        $this->assertEquals(1, $exitCode);
    }

    public function testWithFullProgression()
    {
        LanguageServiceMock::$languages = [new LanguageStub1()];
        $exitCode = $this->commandTester->execute(
            ['command' => CheckTranslationProgressCommand::COMMAND_NAME, '--locale' => [LanguageStub1::LOCALE]]
        );
        $this->assertEquals([LanguageStub1::LOCALE], LanguageServiceMock::$locales);
        $this->assertTrue(LanguageServiceMock::$calledGetLanguages);
        $this->assertEquals(0, $exitCode);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $command = new CheckTranslationProgressCommand();
        $command->setContainer($this->getContainer());

        $application = new Application();
        $application->add($command);

        $this->commandTester = new CommandTester($application->find($command->getName()));
    }
}
