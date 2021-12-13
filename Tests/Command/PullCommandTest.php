<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Command\PullCommand;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services\TranslationServiceMock;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PullCommandTest extends \PHPUnit\Framework\TestCase
{
    use CommandTestCase;

    /**
     * @var CommandTester
     */
    private $commandTester;

    public function testWithoutLocalesExecute()
    {
        $this->commandTester->execute(['command' => PullCommand::COMMAND_NAME]);
        $this->assertEquals([], TranslationServiceMock::$locales);
    }

    public function testWithLocalesExecute()
    {
        $this->commandTester->execute(['command' => PullCommand::COMMAND_NAME, '--locale' => ['es']]);
        $this->assertEquals(['es'], TranslationServiceMock::$locales);
    }

    public function testWithoutFilePathsExecute()
    {
        $this->commandTester->execute(['command' => PullCommand::COMMAND_NAME]);
        $this->assertEquals([], TranslationServiceMock::$pulledFilePaths);
    }

    public function testWithFilePathExecute()
    {
        $this->commandTester->execute(['command' => PullCommand::COMMAND_NAME, '--filePath' => [self::$filePaths]]);
        $this->assertEquals([self::$filePaths], TranslationServiceMock::$pulledFilePaths);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $command = new PullCommand();
        $command->setContainer($this->getContainer());

        $application = new Application();
        $application->add($command);

        $this->commandTester = new CommandTester($application->find($command->getName()));
    }
}
