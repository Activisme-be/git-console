<?php

namespace ActivismeBe\Console\Utils;

class ArrayUtil
{
    public static function get(array $array, $key)
    {
        return (array_key_exists($key, $array)) ? $array[$key] : null;
    }

    public static function filter(array $array)
    {
        if (isset($array['.'])) {
            unset($array['.']);
        }

        if (isset($array['..'])) {
            unset($array['..']);
        }

        unset($array[0]);
        unset($array[1]);

        return $array;
    }
}