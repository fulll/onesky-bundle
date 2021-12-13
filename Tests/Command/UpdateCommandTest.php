<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Command\UpdateCommand;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Services\TranslationServiceMock;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UpdateCommandTest extends \PHPUnit\Framework\TestCase
{
    use CommandTestCase;

    /**
     * @var CommandTester
     */
    private $commandTester;

    public function testExecute()
    {
        $this->commandTester->execute(['command' => UpdateCommand::COMMAND_NAME]);
        $this->assertTrue(TranslationServiceMock::$updateCalled);
        $this->assertEquals([], TranslationServiceMock::$updatedFilePaths);
        $this->assertEquals([], TranslationServiceMock::$locales);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $command = new UpdateCommand();
        $command->setContainer($this->getContainer());

        $application = new Application();
        $application->add($command);

        $this->commandTester = new CommandTester($application->find($command->getName()));
    }
}
