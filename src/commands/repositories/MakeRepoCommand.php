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

    /**
     * Command configuration.
     *
     * @return int|void|null
     */
    protected function configure()
    {
        $this->setName('repo:create');
        $this->setDescription('Nuke a new GitHub repository on github.');

        $this->addArgument('name', InputArgument::REQUIRED, 'Repository name');

        $this->addOption('license', null, InputOption::VALUE_NONE, 'Add a LICENSE file to the repository.');
        $this->addOption('conduct', null, InputOption::VALUE_NONE, 'Add a CONDUCT file to the repository.');
        $this->addOption('readme', null, InputOption::VALUE_NONE, 'Add a README file to the repository.');
    }

    /**
     * Command logic
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $create = new ConfirmationQuestion("Are u sure you want create the repository (" . $input->getArgument('name') . '): ', false);

        if (! $helper->ask($input, $output, $create)) {
            return;
        }

        //> START: Create repository
        $this->user()->api('repo')->create($input->getArgument('name'));
        $output->writeln("<info>OK:</info> Repository created.");
        //> END: Create repository

        //> START: Set license file to the repo.
        if (! empty($input->getOption('license'))) { // The --license flag is used.
            // Stub data
            $licenseFile = file_get_contents(__DIR__ . '/../../stubs/license.md');
            $licenseFile = str_replace('{YEAR}', date('Y'), $licenseFile);
            $licenseFile = str_replace('{AUTHOR}', getenv('GITHUB_USER'), $licenseFile);

            // License meta data
            $author1        = ['name' => getenv('GITHUB_USER'), 'email' => 'Topairy@gmail.com'];
            $branch1        = 'master';
            $owner1         = getenv('GITHUB_USER');
            $repo1          = $input->getArgument('name');
            $path1          = 'LICENSE';
            $content1       = $licenseFile;
            $commitMessage1 = '[ENVOYER]: created the license file.';

            $this->createFileGit($owner1, $repo1, $path1, $content1, $commitMessage1, $branch1, $author1);
            $output->writeln("<info>OK:</info> License created.");
        }
        //> END: Set license file to the repo.

        //> START: set code of conduct to the repository.
        if (! empty($input->getOption('conduct'))) { // The --conduct flag is set.
            // Conduct file meta data.
            $branch2         = 'master';
            $owner2          = getenv('GITHUB_USER');
            $author2         = ['name' => getenv('GITHUB_USER'), 'email' => 'Topairy@gmail.com'];
            $repo2           = $input->getArgument('name');
            $path2           = 'CONDUCT.md';
            $content2        = file_get_contents(__DIR__ . '/../../stubs/conduct.md');
            $commitMessage2  = '[ENVOYER]: created the code of conduct.';

            $this->createFileGit($owner2, $repo2, $path2, $content2, $commitMessage2, $branch2, $author2);
            $output->writeln("<info>OK:</info> Code of conduct created.");
        }
        //> END: Set code of conduct to the repo.

        //> Start: set readme to the repository.
        if (! empty($input->getOption('readme'))) { // The --readme flag is set.
            // Readme meta data;
            $branch3         = 'master';
            $owner3          = getenv('GITHUB_USER');
            $author3         = ['name' => getenv('GITHUB_USER'), 'email' => 'Topairy@gmail.com'];
            $repo3           = $input->getArgument('name');
            $path3           = 'README.md';
            $content3        = file_get_contents(__DIR__ . '/../../stubs/readme.md');
            $content3        = str_replace('{NAME}', $input->getArgument('name'), $content3);
            $commitMessage3  = '[ENVOYER]: created the readme.';

            if ($this->CreateFileGit($owner3, $repo3, $path3, $content3, $commitMessage3, $branch3, $author3)) {
                $msg = "<info>OK:</info> Readme file created.";
            } else {
                $msg = "<info>NOT OK:</info> Could not create readme file.";
            }

            $output->writeln($msg);
        }
        //> END: Set readme to the repository
    }
}
