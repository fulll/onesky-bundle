<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Command;

use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationDownloadTranslationEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPostPullEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPostPushEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPrePullEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationPrePushEvent;
use OpenClassrooms\Bundle\OneSkyBundle\EventListener\TranslationUploadTranslationEvent;
use OpenClassrooms\Bundle\OneSkyBundle\Model\ExportFile;
use OpenClassrooms\Bundle\OneSkyBundle\Model\UploadFile;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class Command extends \Symfony\Component\Console\Command\Command
{
    public const PROGRESS_BAR_FORMAT = "<comment>%message%</comment>\n %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%";

    private ProgressBar $progressBar;

    protected EventDispatcherInterface $eventDispatcher;
    protected int $projectId;

    abstract protected function getCommandName(): string;

    abstract protected function getCommandDescription(): string;

    protected function handlePullDisplay(OutputInterface $output): void
    {
        $this->eventDispatcher->addListener(
            TranslationPrePullEvent::getEventName(),
            function (TranslationPrePullEvent $event) use ($output) {
                $output->writeln('<info>Pulling for project id '.$this->getProjectId()."</info>\n");
                $this->progressBar = new ProgressBar($output, $event->getExportFilesCount());
                $this->progressBar->setFormat(self::PROGRESS_BAR_FORMAT);
                $this->getProgressBar()->start();
            }
        );

        $this->eventDispatcher->addListener(
            TranslationDownloadTranslationEvent::getEventName(),
            function (TranslationDownloadTranslationEvent $event) {
                $this->getProgressBar()->setMessage(
                    '<comment>'.$event->getExportFile()->getTargetFilePathRelativeToProject().'</comment>'
                );
                $this->getProgressBar()->advance();
            }
        );

        $this->eventDispatcher->addListener(
            TranslationPostPullEvent::getEventName(),
            function (TranslationPostPullEvent $event) use ($output) {
                $this->progressBar->finish();
                $output->writeln('<info>'.\count($event->getDownloadedFiles()).' files downloaded. </info>');
                $table = new Table($output);
                $table
                    ->setHeaders(['File', 'Locale'])
                    ->setRows(
                        array_map(
                            static function (ExportFile $file) {
                                return [$file->getSourceFilePathRelativeToProject(), $file->getRequestedLocale()];
                            },
                            $event->getDownloadedFiles()
                        )
                    );
                $table->render();
            }
        );
    }

    private function getProjectId(): string
    {
        return $this->projectId;
    }

    private function getProgressBar(): ProgressBar
    {
        return $this->progressBar;
    }

    protected function handlePushDisplay(OutputInterface $output): void
    {
        $this->eventDispatcher->addListener(
            TranslationPrePushEvent::getEventName(),
            function (TranslationPrePushEvent $event) use ($output) {
                $output->writeln('<info>Pushing for project id '.$this->getProjectId()."</info>\n");
                $this->progressBar = new ProgressBar($output, $event->getUploadFilesCount());
                $this->progressBar->setFormat(self::PROGRESS_BAR_FORMAT);
                $this->getProgressBar()->start();
            }
        );

        $this->eventDispatcher->addListener(
            TranslationUploadTranslationEvent::getEventName(),
            function (TranslationUploadTranslationEvent $event) {
                $this->getProgressBar()->setMessage($event->getUploadFile()->getSourceFilePathRelativeToProject());
                $this->getProgressBar()->advance();
            }
        );

        $this->eventDispatcher->addListener(
            TranslationPostPushEvent::getEventName(),
            function (TranslationPostPushEvent $event) use ($output) {
                $this->progressBar->finish();
                $output->writeln('');
                $output->writeln('<info>'.\count($event->getUploadedFiles()).' files downloaded. </info>');
                $table = new Table($output);
                $table
                    ->setHeaders(['File', 'Locale'])
                    ->setRows(
                        array_map(
                            static function (UploadFile $file) {
                                return [$file->getSourceFilePathRelativeToProject(), $file->getSourceLocale()];
                            },
                            $event->getUploadedFiles()
                        )
                    );
                $table->render();
            }
        );
    }
}
