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
use Symfony\Component\Console\Helper\ProgressBar;

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
        $io     = new \Symfony\Component\Console\Style\SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $name        = new Question('Group name:        ');
        $description = new Question('Group description: ');

        $data['name']        = $helper->ask($input, $output, $name);
        $data['description'] = $helper->ask($input, $output, $description);

        $group = Groups::create($data);

        if ($group) { // The group is created. Now ask if they want to assign labels.
            if ((bool) $input->getOption('assign') === true) { // --assign flag is set.
                $issueArr  = [];

                foreach (Labels::all() as $issue) {
                    array_push($issueArr, $issue->name);
                }

                $question = new ChoiceQuestion('What issues u want to assign:', $issueArr, 0);
                $question->setMultiselect(true);

                foreach ($helper->ask($input, $output, $question) as $identifier) {
                    $record = Labels::where('name', $identifier)->get()->first();
                    Labels::find($record->id)->group()->attach($group->id);
                }
            }

            $io->newLine();
            $output->writeln("<info>OK:</info> All operations are done.");
            $io->newLine();
        }
    }
}
