<?php

namespace ActivismeBe\Console\Commands\Database;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpCommand extends AbstractEnvCommand {

    protected function configure()
    {
        $this->setName('migrate:up');
        $this->setDescription('Execute all waiting migration up to [to] option if precised');

        $this->addArgument('env', InputArgument::REQUIRED, 'Environment');

        $this->addOption('to', null, InputOption::VALUE_REQUIRED, 'Migration will be uped up to this migration id included');
        $this->addOption('only', null, InputOption::VALUE_REQUIRED, 'If you need to up this migration id only');
        $this->addOption('changelog-only', null, InputOption::VALUE_NONE, 'Mark as applied without executing SQL ');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->checkEnv();
        $this->init($input, $output);

        $changeLogOnly = (bool) $input->getOption('changelog-only');
        $toExecute     = $this->filterMigrationsToExecute($input, $output);

        if (count($toExecute) == 0) {
            $output->writeln("your database is already up to date");
        } else {
            $progress = new ProgressBar($output, count($toExecute));
            $progress->setFormat(self::$progressBarFormat);
            $progress->setMessage('');
            $progress->start();

            foreach ($toExecute as $migration) {
                $progress->setMessage($migration->getDescription());
                $this->executeUpMigration($migration, $changeLogOnly);
                $progress->advance();
            }

            $progress->finish();
            $output->writeln("");
        }
    }
}