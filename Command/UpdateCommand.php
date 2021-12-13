<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UpdateCommand extends Command
{
    public const COMMAND_NAME = 'openclassrooms:one-sky:update';

    public const COMMAND_DESCRIPTION = 'Update translations';

    protected function configure()
    {
        $this->setName($this->getCommandName())
            ->setDescription($this->getCommandDescription());
    }

    /**
     * @return string
     */
    protected function getCommandName()
    {
        return self::COMMAND_NAME;
    }

    protected function getCommandDescription()
    {
        return self::COMMAND_DESCRIPTION;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Updating translations</info>\n");
        $this->handlePullDisplay($output);
        $this->handlePushDisplay($output);
        $this->getContainer()->get('openclassrooms.onesky.services.translation_service')->update();
    }
}
