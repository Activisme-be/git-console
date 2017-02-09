<?php

namespace ActivismeBe\Console\Commands;

use ActivismeBe\Console\Utils\Github;
use ActivismeBe\Console\Database\Models\Labels;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateLabelCommand extends Command
{
    use GitHub;

    /**
     * Configure the command.
     *
     * @return int|null|void
     */
    protected function configure()
    {
        // Configure the arguments and call methods.
        $this->setName('label:create');
        $this->setDescription('Create a new label locally or on GitHub');
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
        $helper = $this->getHelper('question');

        $name    = new Question('The name for the label: ');
        $hex     = new Question('The HEX color value for the label: ');
        $project = new Question('GitHub Project: ');

        $locations = ['Local', 'GitHub'];

        $publish   = new ChoiceQuestion('Place select the destination for the label: ', $locations, 0);
        $publish->setMultiselect(true);

        // Set output to variables.
        $data['name']     = $helper->ask($input, $output, $name);
        $data['hexColor'] = $helper->ask($input, $output, $hex);
        $data['location'] = $helper->ask($input, $output, $publish);

        foreach ((array) $data['location'] as $info => $item) {
            if ((string) $item === 'Local') {
                Labels::create($input);
                return $output->writeln("<info>INFO:</info> The label is created");
            }

            if ((string) $item === 'GitHub') {
                $styling  = new SymfonyStyle($input, $output);
                $styling->newLine();

                $repo = $helper->ask($input, $output, $project);

                $this->user()->api('issue')->labels()->create(getenv('GITHUB_USER'), $repo, [
                    'name'  => $input['name'],
                    'color' => $input['hexColor']
                ]);

               return $output->writeln("<info>INFO:</info> The label is published to github.");
            }
        }
    }
}