<?php

namespace ActivismeBe\Console\Commands;

use ActivismeBe\Console\Helpers\EnvConfig;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class ChangeEnvCommand extends Command
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
        $this->setName('setup:database');
        $this->setDescription('Setup the database connection.');
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

        if (! $helper->ask($input, $output, $question)) { // The doesn't want to continue.
            $msg = '<error>We will not continue with the function</error>';
            return $output->writeln($msg);
        }

        // User want to continu.

        $styling->newLine();

        $passQuestion = new Question('Pass: ');
        $passQuestion->setHidden(true)->setHiddenFallback(false);

        $hostQuestion = new Question('Host: ');
        $userQuestion = new Question('User: ');
        $dbQuestion   = new Question('Database: ');

        $update['DB_DATABASE'] = $helper->ask($input, $output, $dbQuestion);
        $update['DB_HOST']     = $helper->ask($input, $output, $hostQuestion);
        $update['DB_USERNAME'] = $helper->ask($input, $output, $userQuestion);
        $update['DB_PASSWORD'] = $helper->ask($input, $output, $passQuestion);

        if ($this->changeEnv($update)) { // .env data changed
            $outputMsg = '<info>The database setup is saved!</info>';
        } else {
            $outputMsg = '<error>We could not save the database setup.</error>';
        }

        // Env data doesn't change.
        $styling->newLine();
        return $output->writeln($outputMsg);

    }
}
