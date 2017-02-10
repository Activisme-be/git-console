<?php

namespace ActivismeBe\Console\Commands\Repositories;

use ActivismeBe\Console\Utils\Github;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class MakeRepoCommand extends Command
{
    use Github;

    protected function configure()
    {
        $this->setName('repo:create');
        $this->setDescription('Nuke a new GitHub repository on github.');

        $this->addArgument('name', InputArgument::REQUIRED, 'Repository name');

        $this->addOption('license', null, InputOption::VALUE_NONE, 'Add a LICENSE file to the repository.');
        $this->addOption('conduct', null, InputOption::VALUE_NONE, 'Add a CONDUCT file to the repository.');
        $this->addOption('readme', null, InputOption::VALUE_NONE, 'Add a README file to the repository.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $create = new ConfirmationQuestion("Are u sure you want create the repository (" . $input->getArgument('name') . '): ', false);

        if (! $helper->ask($input, $output, $create)) {
            return;
        }

        //> START: Create repository
        $this->user()->api('repo')->create($input->getArgument('name'));
        //> END: Create repository

        //> START: Set license file to the repo.
        if (! empty($input->getOption('license'))) { // The --license flag is used.
            // License meta data
            $license['author']      = getenv('GITHUB_USER');
            $license['project']     = $input->getArgument('name');
            $license['path']        = '/';
            $license['content']     = '';
            $license['commit']      = '[ENVOYER]: Added LICENSE file.';

            $this->createFileGit($license);
        }
        //> END: Set license file to the repo.
    }
}
