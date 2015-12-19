<?php
/**
 * MicroFramework
 * version 0.3
 *
 * @author Alexandre Almeida Ferreira <alexandrealmeidaferreira@gmail.com>
 */
ini_set('display_errors', 1);
chdir(dirname(__DIR__));

define('APP_ENV', (getenv('APP_ENV')) ? getenv('APP_ENV') : 'development');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', __DIR__ . DS . '..' . DS);
define('CONFIG_DIR', ROOT_DIR . 'config' . DS);
define('CORE_DIR', ROOT_DIR . 'core' . DS);
define('MODULES_DIR', ROOT_DIR . 'modules' . DS);
define('JS_DIR', ROOT_DIR . 'public' . DS . 'js' . DS);
define('CSS_DIR', ROOT_DIR . 'public' . DS . 'css' . DS);

require_once('core/Application.php');

$app = new \core\Application();
$app->start();
