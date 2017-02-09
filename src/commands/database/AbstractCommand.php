<?php

namespace ActivismeBe\Console\Commands\Database;

use Symfony\Component\Console\Command\Command;

class AbstractCommand extends Command
{
    protected $mainDir;
    protected $environmentDir;
    protected $migrationDir;

    /**
     * AbstractCommand constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->mainDir        = getcwd() . '/config';
        $this->environmentDir = $this->mainDir . '/environments';
        $this->migrationDir   = $this->mainDir . '/migrations';
    }

    public function mainDir()
    {
        return $this->mainDir;
    }

    public function getMigrationDir()
    {
        return $this->migrationDir;
    }

    public function getEnvironmentDir()
    {
        return $this->environmentDir;
    }
}