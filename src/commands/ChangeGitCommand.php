<?php

namespace ActivismeBe\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeGitCommand extends Command
{
    /**
     * Configure the command.
     *
     * @return int|null|void
     */
    protected function configure()
    {
        // Configure the arguments and call methods.
        $this->setName('setup:github');
        $this->setDescription('Connect the traveller to GitHub');
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
        //
    }
}