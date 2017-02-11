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

            $this->createFileGit($author, $repo, $path, $content, $commitMessage, $branch, $commiter);
        }
        //> END: Set license file to the repo.

        //>
        if (! empty($input->getOption('conduct'))) { // The --conduct flag is set.
            // Conduct file meta data.
            $branch2         = 'master';
            $owner2          = getenv('GITHUB_USER');
            $author2         = getenv('GITHUB_USER');
            $repo2           = $input->getArgument('name');
            $path2           = '/CONDUCT.md';
            $content2        = file_get_contents(__DIR__ . '/../../stubs/conduct.md');
            $commitMessage2  = '[ENVOYER]: Added code of conduct.';

            $this->createFileGit($owner2, $repo2, $path2, $content2, $commitMessage2, $branch2, $author2);
        }
        //> END: Set code of conduct to the repo.

        //>
        if (! empty($input->getOption('readme'))) { // The --readme flag is set.
            // Readme meta data;
            $branch3         = 'master';
            $owner3          = getenv('GITHUB_USER');
            $author3         = getenv('GITHUB_USER');
            $repo3           = $input->getArgument('name');
            $path3           = '/README.md';
            $content3        = file_get_contents(__DIR__ . '/../../stubs/readme.md');
            $content3        = str_replace('{NAME}', $input->getArgument('name'), $content3);
            $commitMessage3  = '[ENVOYER]: Added Readme';

            $this->CreateFileGit($owner3, $repo3, $path3, $content3, $commitMessage3, $branch3, $author3);
        }
        //>
    }
}
