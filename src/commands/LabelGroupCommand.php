<?php

namespace ActivismeBe\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LabelGroupCommand extends Command
{
    /**
     * Configure the command.
     *
     * @return int|null|void
     */
    protected function configure()
    {
        // Configure the arguments and call methods.
        $this->setName('info:label-groups');
        $this->setDescription('Show the documentation about the issue label groups.');
        $this->addArgument('group', InputArgument::OPTIONAL, 'The issue label group.');
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
