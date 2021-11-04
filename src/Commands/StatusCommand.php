<?php

namespace DavidPeach\Manuscript\Commands;

use DavidPeach\Manuscript\Playgrounds;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StatusCommand extends BaseCommand
{
    protected static $defaultName = 'status';

    protected function configure(): void
    {
        parent::configure();

        $this
            ->setHelp(help: 'TODO')
            ->setDescription(description: 'TODO');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $root = ($input->getOption(name: 'dir') ?? getcwd());

        $playgrounds = (new Playgrounds)->discover(root: $root);

        $tableRows = [];

        foreach ($playgrounds as $playground) {
            $tableRows[] = [
                $playground->getName()
            ];
        }

        $output->writeln(messages: 'Playgrounds');
        $table = new Table(output: $output);
        $table
            ->setHeaders(headers: ['Title'])
            ->setRows(rows: $tableRows)
        ;
        $table->render();

        return Command::SUCCESS;
    }
}
