<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

use OpenClassrooms\Bundle\OneSkyBundle\Model\Language;
use OpenClassrooms\Bundle\OneSkyBundle\Services\Impl\LanguageServiceImpl;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CheckTranslationProgressCommand extends Command
{
    public const COMMAND_NAME = 'openclassrooms:one-sky:check-translation-progress';
    public const COMMAND_DESCRIPTION = 'Check translations progress';
    private LanguageServiceImpl $languageService;

    public function __construct(EventDispatcherInterface $eventDispatcher, int $projectId, LanguageServiceImpl $languageService, string $name = null)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->languageService = $languageService;
        $this->projectId = $projectId;

        parent::__construct($name);
    }

    protected function configure(): void
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

    protected function getCommandName(): string
    {
        return self::COMMAND_NAME;
    }

    protected function getCommandDescription(): string
    {
        return self::COMMAND_DESCRIPTION;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Check translations progress</info>');
        $languages = $this->languageService->getLanguages($input->getOption('locale'));
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
