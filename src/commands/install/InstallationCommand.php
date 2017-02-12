<?php

namespace ActivismeBE\Console\Commands\InstallCommand;

use ActivismeBe\Console\Helpers\EnvConfig;
use Symfony\Component\Console\Command\Command;

/**
 * Class InstallationCommand
 *
 * @package ActivismeBE\Console\Commands\InstallCommand
 */
class InstallationCommand extends Command
{
    use EnvConfig;

    /**
     * Command configuration.
     *
     * @return int|null|void
     */
    protected function configure()
    {

    }

    /**
     * Command logic
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $update[] = '';
        $update[] = '';
        $update[] = '';
        $update[] = '';
        $update[] = '';
        $update[] = '';

        if ($this->changeEnv($update)) { // .env data changed
            $outputMsg = '<info>Envoyer is installed!</info>';
        } else {
            $outputMsg = '<error>Could not install envoyer.</error>';
        }
    }
}
