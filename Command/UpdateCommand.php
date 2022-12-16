<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Services\TranslationService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UpdateCommand extends Command
{
    public const COMMAND_NAME = 'openclassrooms:one-sky:update';
    public const COMMAND_DESCRIPTION = 'Update translations';

    private TranslationService $translationService;

    public function __construct(EventDispatcherInterface $eventDispatcher, int $projectId, TranslationService $translationService, string $name = null)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->translationService = $translationService;
        $this->projectId = $projectId;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName($this->getCommandName())
            ->setDescription($this->getCommandDescription());
    }

    protected function getCommandName(): string
    {
        return self::COMMAND_NAME;
    }

    protected function getCommandDescription(): string
    {
        return self::COMMAND_DESCRIPTION;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Updating translations</info>\n");
        $this->handlePullDisplay($output);
        $this->handlePushDisplay($output);
        $this->translationService->update();
    }
}
