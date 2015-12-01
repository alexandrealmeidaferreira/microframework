<?php
/**
 * Satannish MicroFramework
 * version 0.1
 *
 * @author Alexandre Almeida Ferreira <alexandrealmeidaferreira@gmail.com>
 */
ini_set('display_errors', 1);
chdir(dirname(__DIR__));

define('ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);
define('CONFIG_DIR', ROOT_DIR . 'config' . DIRECTORY_SEPARATOR);
define('CORE_DIR', ROOT_DIR . 'core' . DIRECTORY_SEPARATOR);
define('MODULES_DIR', ROOT_DIR . 'modules' . DIRECTORY_SEPARATOR);

use core\Application;
use core\Layout;
use core\Debug;

require_once('core/Application.php');

$app = new Application();
$app->start();

//$layout = new Layout();
//$layout->loadLayout();





//Debug::dump($_GET);
//Debug::dump($_REQUEST);


//$router = new Router();

/*$r = $router->isValid('home-route');
var_dump($r);

$url = $router->routeToUrl('home-route');
Debug::dump($url);

$url = $router->routeToUrl('test-route', array('id' => '7777', 'empty' => 'false'));
Debug::dump($url);*/


/*$r = $router->matchRoute();
Debug::dump($r);

$r = $router->matchRoute('bunda');
var_dump($r);*/
//sleep(5);
//$router->redirect('test-route', array('id' => '666'));
//$router->redirect('http://www.google.com.br');



/*namespace satannish_music;

use core\Router as Router;

Router::route('blog/(\w+)/(\d+)', function($category, $id){
    print $category . ':' . $id;
});

Router::execute('blog/edit/123');*/