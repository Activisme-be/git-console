<?php

namespace ActivismeBe\Console\Utils;

use Dotenv\Dotenv;
use Github\Client;
use Symfony\Component\Config\Definition\Exception\Exception;

trait Github
{
    /**
     * Authencate the used on github for a request.
     *
     * @return mixed
     */
    public function user()
    {
        $env = new Dotenv(__DIR__ .'/../../');
        $env->load();

        $github = new Client();
        $github->authenticate(getenv('GITHUB_USER'), getenv('GITHUB_PASS'), Client::AUTH_HTTP_PASSWORD);

        return $github;
    }

    /**
     * Push a new file towards GitHub
     *
     * @param  string  $author
     * @param  string  $repo
     * @param  string  $path
     * @param  string  $content
     * @param  string  $commitMessage
     * @param  string  $branch
     * @param  array   $commiter
     * @return bool
     */
    public function createFileGit($author, $repo, $path, $content, $commitMessage, $branch, $commiter)
    {
        $gitFile  = $this->user()->api('repo')->contents();

        if ($gitFile->create($author, $repo, $path, $content, $commitMessage, $branch, $commiter)) {
            return true;
        } else {
            return false;
        }
    }
}
