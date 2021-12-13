<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Command\PushCommand;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services\TranslationServiceMock;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PushCommandTest extends \PHPUnit\Framework\TestCase
{
    use CommandTestCase;

    /**
     * @var CommandTester
     */
    private $commandTester;

    public function testWithoutLocalesExecute()
    {
        $this->commandTester->execute(['command' => PushCommand::COMMAND_NAME]);
        $this->assertEquals([], TranslationServiceMock::$locales);
    }

    public function testWithLocalesExecute()
    {
        $this->commandTester->execute(['command' => PushCommand::COMMAND_NAME, '--locale' => ['es']]);
        $this->assertEquals(['es'], TranslationServiceMock::$locales);
    }

    public function testWithoutFilePathsExecute()
    {
        $this->commandTester->execute(['command' => PushCommand::COMMAND_NAME]);
        $this->assertEquals([], TranslationServiceMock::$pushedFilePaths);
    }

    public function testWithFilePathExecute()
    {
        $this->commandTester->execute(['command' => PushCommand::COMMAND_NAME, '--filePath' => [self::$filePaths]]);
        $this->assertEquals([self::$filePaths], TranslationServiceMock::$pushedFilePaths);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $command = new PushCommand();
        $command->setContainer($this->getContainer());

        $application = new Application();
        $application->add($command);

        $this->commandTester = new CommandTester($application->find($command->getName()));
    }
}
