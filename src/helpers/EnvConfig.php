<?php

namespace ActivismeBe\Console\Helpers;

trait EnvConfig
{
    /**
     * Change the database env settings.
     *
     * @param  array $data
     * @return bool
     */
    protected function changeEnv($data = [])
    {
        if (count($data) > 0){
            $env = file_get_contents(__DIR__ . '/../../.env');
            $env = preg_split('/\s+/', $env);;

            foreach ((array) $data as $key => $value) {
                foreach ($env as $env_key => $env_value) {
                    $entry = explode("=", $env_value, 2);

                    if ($entry[0] == $key) {
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        $env[$env_key] = $env_value;
                    }
                }
            }

            $env = implode("\n", $env);
            file_put_contents(__DIR__ . '/../../.env', $env);

            return true;
        } else {
            return false;
        }
    }
}