<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 29/11/15
 * Time: 15:45
 */

namespace core;


class Debug
{
    /**
     * Simple dump variables with print_r
     *
     * @param $var
     * @param bool|false $return
     * @return mixed
     */
    public static function print_r($var, $return = false)
    {
        $dump = print_r($var, true);
        if ($return) {
            return $dump;
        } else {
            echo "<pre>";
            echo $dump;
            echo "</pre>";
        }
    }

    /**
     * Dump with var_dump
     *
     * @param $var
     */
    public static function dump($var)
    {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }
}