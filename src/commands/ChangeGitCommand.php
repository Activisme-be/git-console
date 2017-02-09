<?php

namespace ActivismeBe\Console\Commands;

use ActivismeBe\Console\Helpers\EnvConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class ChangeGitCommand extends Command
{
    use EnvConfig;

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
        $helper   = $this->getHelper('question');

        $styling  = new SymfonyStyle($input, $output);
        $question = new ConfirmationQuestion('Are u sure u want to continue? [yes/no]:', false);

        $styling->newLine();

        if (! $helper->ask($input, $output, $question)) { // The doesn't want to continue.
            $msg = '<error>We will not continue with the function</error>';
            return $output->writeln($msg);
        }

        $userQuestion = new Question('GitHub user: ');

        $passQuestion = new Question('GitHub pass: ');
        $passQuestion->setHidden(true)->setHiddenFallback(false);

        // Update variables
        $update['GITHUB_USER'] = $helper->ask($input, $output, $userQuestion);;
        $update['GITHUB_PASS'] = $helper->ask($input, $output, $passQuestion);;

        if ($this->changeEnv($update)) { // .env data changed
            $outputMsg = '<info>The Github setup is saved!</info>';
        } else {
            $outputMsg = '<error>We could not save the GitHub setup.</error>';
        }

        // Env data doesn't change.
        $styling->newLine();
        return $output->writeln($outputMsg);
    }
}