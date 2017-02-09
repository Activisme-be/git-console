<?php

namespace ActivismeBe\Console\Commands\Database;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends AbstractEnvCommand
{
    /**
     * Configure the command.
     *
     * @return int|null|void
     */
    protected function configure()
    {
        // Configure the arguments and call methods.
        $this->setName('migrate:init');
        $this->setDescription('Create the changelog table on your environment database');
        $this->addArgument('env', InputArgument::REQUIRED, 'environment');
    }

    /**
     * The command logic.
     *
     * @param   InputInterface $input
     * @param   OutputInterface $output
     * @return  mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->init($input, $output);

        $changelog = $this->getChangelogTable();

        $this->getDb()->exec("
            CREATE table $changelog
            (
                id numeric(20,0),
                applied_at character varying(25),
                version character varying(25),
                description character varying(255)
            )
        ");
        $output->writeln("changelog table ($changelog) successfully created");

    }
}