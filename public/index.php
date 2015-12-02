<?php
/**
 * MicroFramework
 * version 0.1
 *
 * @author Alexandre Almeida Ferreira <alexandrealmeidaferreira@gmail.com>
 */
ini_set('display_errors', 1);
chdir(dirname(__DIR__));

define('ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('CONFIG_DIR', ROOT_DIR . 'config' . DIRECTORY_SEPARATOR);
define('CORE_DIR', ROOT_DIR . 'core' . DIRECTORY_SEPARATOR);
define('MODULES_DIR', ROOT_DIR . 'modules' . DIRECTORY_SEPARATOR);

require_once('core/Application.php');

$app = new \core\Application();
$app->start();
