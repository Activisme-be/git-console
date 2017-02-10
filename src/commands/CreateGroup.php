<?php

namespace ActivismeBe\Console\Commands;

use ActivismeBe\Console\Database\Models\Labels;
use ActivismeBe\Console\Database\Models\Groups;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;

class CreateGroup extends Command
{
    /**
     * Configure function. Contains all the meta data.
     *
     * @return int|null|void
     */
    protected function configure()
    {
        $this->setName('label-group:create');
        $this->setDescription('Create a new label group locally.');

        $this->addOption('assign', null, InputOption::VALUE_NONE, 'Assign labels to the group.');
    }

    /**
     * Execute function for the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $name        = new Question('Group name:        ');
        $description = new Question('Group description: ');

        $data['name']        = $helper->ask($input, $output, $name);
        $data['description'] = $helper->ask($input, $output, $description);

        if (Groups::create($data)) { // The group is created. Now ask if they want to assign labels.
            $output->writeln("<info>INFO:</info> The group has been created.");

            if ((bool) $input->getOption('assign') === true) { // --assign flag is set.
                $issues   = Labels::select(['id', 'name'])->get()->toArray();
                $question = new ChoiceQuestion('What issues u want to assign:', $issues, 0);
                $question->setMultiselect(true);

                if () { // CHECK PASSES: The labels are connected to the group.
                    $output->writeln("<info>INFO:</info> The labels are assigned to the group");
                }
            }
        }
    }
}
