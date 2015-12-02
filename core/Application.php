<?php
/**
 * Initial Application
 *
 * User: alexandre
 * Date: 29/11/15
 * Time: 15:25
 */

namespace core;


class Application
{
    private $autoloaderFile = 'autoloader.php';
    private $router;
    private $layout;
    private static $action;

    public function __construct($autoInitAutoLoader = true)
    {
        //inits automatically the autoloader, it can be disabled
        if ($autoInitAutoLoader) {
            $this->initAutoLoader();
        }

        //check if loader exists
        if (class_exists('core\Router')) {
            $this->router = new Router();
        }

        //check if layout class exists
        if (class_exists('core\Layout')) {
            $this->layout = new Layout();
        }
    }

    /**
     * Start the application
     */
    public function start()
    {
        //match the current route
        $route = $this->router->matchRoute();
        if ($route) {
            //rewrite the GET
            $_GET = array(
                'Module' => $route['route']['Module'],
                'Controller' => $route['route']['Controller'],
                'Action' => $route['route']['Action']
            );
            if (!empty($route['params'])) {
                $_GET = array_merge($_GET, $route['params']);
            }

            switch ($this->renderAction($route)) {
                default:
                case View::HTML:
                    $this->layout->loadLayout($route);
                    break;
                case View::JSON:
                    //serve the json value
                    header('Cache-Control: no-cache, must-revalidate');
                    header('Expires: Mon, 08 Jul 1985 19:05:00 GMT');
                    header('Content-type: application/json');
                    exit(self::$action);
                    break;
            }
        }
    }

    /**
     * Init the controller and execute the action
     *
     * @param $route
     */
    private function renderAction($route)
    {
        //loads the class from matched route
        try {
            //create a instance of controller
            $class = $this->loadControllerClass($route['route']['Module'], $route['route']['Controller']);
            //execute the action
            ob_start();
            $viewClass = $class->{$route['route']['Action'] . 'Action'}();
            Application::$action = ob_get_clean();
        } catch (\Exception $e) {
            echo $e->getCode() . ' - ' . $e->getMessage();
            Debug::dump($e->getTraceAsString());
            exit;
        }

        return isset($viewClass) ? $viewClass->getRenderType() : View::HTML;
    }

    /**
     * Return an instance of Module/Controller
     *
     * @param $module
     * @param $controller
     * @return mixed
     * @throws \Exception
     */
    private function loadControllerClass($module, $controller)
    {
        $controller_namespace = $module . '\Controllers';
        $controller_path = MODULES_DIR . $module . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $controller . 'Controller.php';
        $class_name = $controller_namespace . '\\' . $controller . 'Controller';
        if (is_file($controller_path)) {
            include $controller_path;
            $class = new $class_name;
        } else {
            throw new \Exception('ERROR - Controller "' . $controller_path . '" file not found', 9);
        }
        return $class;
    }


    /**
     * Return the router instance
     *
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }


    /**
     * Do an autoloader with config params
     *
     * @throws \Exception
     */
    public function initAutoLoader()
    {
        if (is_file(CONFIG_DIR . $this->autoloaderFile)) {
            $autoloader = include CONFIG_DIR . $this->autoloaderFile;
            if (!empty($autoloader)) {
                foreach ($autoloader as $file) {
                    if (is_file(ROOT_DIR . $file)) {
                        include ROOT_DIR . $file;
                    } else {
                        throw new \Exception('ERROR - Autoload "' . ROOT_DIR . $file . '" file not found', 2);
                    }
                }
            }
        } else {
            throw new \Exception('ERROR No "' . $this->autoloaderFile . '" found in "' . CONFIG_DIR . '" dir', 1);
        }
    }

    public static function render()
    {
        return Application::$action;
    }
}