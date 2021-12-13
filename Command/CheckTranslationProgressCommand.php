<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Model\Language;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CheckTranslationProgressCommand extends ContainerAwareCommand
{
    public const COMMAND_NAME = 'openclassrooms:one-sky:check-translation-progress';

    public const COMMAND_DESCRIPTION = 'Check translations progress';

    protected function configure()
    {
        $this->setName($this->getCommandName())
            ->setDescription($this->getCommandDescription())
            ->addOption(
                'locale',
                null,
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Requested locales',
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
        $output->writeln('<info>Check translations progress</info>');
        $languages = $this->getContainer()
            ->get('openclassrooms.onesky.services.language_service')
            ->getLanguages($input->getOption('locale'));
        $table = new Table($output);
        $table
            ->setHeaders(['Locale', 'Progression'])
            ->setRows(
                array_map(
                    static function (Language $language) {
                        return [$language->getLocale(), $language->getTranslationProgress()];
                    },
                    $languages
                )
            );
        $table->render();

        foreach ($languages as $language) {
            if (!$language->isFullyTranslated()) {
                return 1;
            }
        }

        return 0;
    }
}
