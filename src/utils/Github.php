<?php

namespace ActivismeBe\Console\Utils;

use Dotenv\Dotenv;
use Github\Client;
use Symfony\Component\Config\Definition\Exception\Exception;

trait Github
{
    /**
     * @return mixed
     */
    public function user()
    {
        $env = new Dotenv(__DIR__ .'/../../');
        $env->load();

        $github = new Client();
        $github->authenticate(getenv('GITHUB_USER'), getenv('GITHUB_PASS'), Client::AUTH_HTTP_PASSWORD);
    }

    public function createFileGit($meta)
    {
        $gitFile  = $this->user()->api('repo')->contents();

        if ($gitFile->create($meta['author'], $meta['project'], $meta['path'], $meta['content'], $meta['commit'])) {
            return true;
        } else {
            return false;
        }
    }
}
