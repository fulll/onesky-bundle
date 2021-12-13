<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PushCommand extends Command
{
    public const COMMAND_NAME = 'openclassrooms:one-sky:push';

    public const COMMAND_DESCRIPTION = 'Push translations';

    protected function configure()
    {
        $this->setName($this->getCommandName())
            ->setDescription($this->getCommandDescription())
            ->addOption('filePath', 'dir', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'File path', [])
            ->addOption(
                'locale',
                null,
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Source locale',
                []
            );
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
        $this->handlePushDisplay($output);
        $this->getContainer()->get('openclassrooms.onesky.services.translation_service')->push(
            $input->getOption('filePath'),
            $input->getOption('locale')
        );
    }
}
