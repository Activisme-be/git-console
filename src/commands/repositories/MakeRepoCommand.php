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
        // TODO: Needs debugging -> in progress

        $helper = $this->getHelper('question');
        $create = new ConfirmationQuestion("Are u sure you want create the repository (" . $input->getArgument('name') . '): ', false);

        if (! $helper->ask($input, $output, $create)) {
            return;
        }

        var_dump($this->user());
        die();

        //> START: Create repository
        $this->user()->api('repo')->create($input->getArgument('name'));
        //> END: Create repository

        //> START: Set license file to the repo.
        if (! empty($input->getOption('license'))) { // The --license flag is used.
            // Stub data
            $licenseFile = file_get_contents(__DIR__ . '/../../stubs/license.md');
            $licenseFile = str_replace('{YEAR}', date('Y'), $licenseFile);
            $licenseFile = str_replace('{AUTHOR}', getenv('GITHUB_USER'), $licenseFile);

            // License meta data
            $license['author']      = getenv('GITHUB_USER');
            $license['project']     = $input->getArgument('name');
            $license['path']        = '/LICENSE';
            $license['content']     = $licenseFile;
            $license['commit']      = '[ENVOYER]: Added LICENSE file.';

            $this->createFileGit($license);
        }
        //> END: Set license file to the repo.

        //>
        if (! empty($input->getOption('conduct'))) { // The --conduct flag is set.
            // Conduct file meta data.
            $conduct['author']  = getenv('GITHUB_USER');
            $conduct['project'] = $input->getArgument('name');
            $conduct['path']    = '/CONDUCT.md';
            $conduct['content'] = file_get_contents(__DIR__ . '/../../stubs/conduct.md');
            $conduct['commit']  = '[ENVOYER]: Added code of conduct.';

            $this->createFileGit($conduct);
        }
        //> END: Set code of conduct to the repo.

        //>
        if (! empty($input->getOption('readme'))) { // The --readme flag is set.
            // Stub data
            $readmeFile = file_get_contents(__DIR__ . '/../../stubs/readme.md');
            $readmeFile = str_replace('{NAME}', $input->getArgument('name'), $readmeFile);

            // Readme meta data;
            $readme['author']  = getenv('GITHUB_USER');
            $readme['project'] = $input->getArgument('name');
            $readme['path']    = '/README.md';
            $readme['content'] = $readmeFile;
            $readme['commit']  = '[ENVOYER]: Added Readme';

            $this->CreateFileGit($readme);
        }
        //>
    }
}
