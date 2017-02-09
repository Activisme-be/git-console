<?php

namespace ActivismeBe\Console\Commands\Database;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StatusCommand extends AbstractEnvCommand
{
    protected function configure()
    {
        $this->setName('migrate:status');
        $this->setDescription('Display the current status of the specified environment');

        $this->addArgument('env', InputArgument::REQUIRED, 'Environment');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->init($input, $output);

        $table = new Table($output);
        $table->setHeaders(array('id', 'version', 'applied at', 'description'));

        $migrations = $this->getRemoteAndLocalMigrations();


        foreach ($migrations as $migration) {
            $table->addRow($migration->toArray());
        }

        $table->render();
    }
}