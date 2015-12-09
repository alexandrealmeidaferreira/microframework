<?php
/**
 * Database configuration
 *
 * User: alexandre
 * Date: 09/12/15
 * Time: 19:56
 */

return array(
    'lotofacil' => array(
        'dsn' => 'mysql:host=localhost;dbname=test',
        'user' => 'root',
        'pass' => '123456',
        'options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
    )
);