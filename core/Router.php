<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 29/11/15
 * Time: 15:18
 */

namespace core;


class Router
{
    private $routeFile = 'routes.php';
    private $routes = array();


    public function __construct()
    {
        if (is_file(CONFIG_DIR . $this->routeFile)) {
            $this->routes = include CONFIG_DIR . $this->routeFile;
        }
    }

    /**
     * Match a route from parameter $route or try to get from $_GET['route']
     *
     * @param string $route
     * @return array|bool
     */
    public function matchRoute($route = '')
    {
        $return = false;

        //try to get route if none passed as parameter
        if (empty($route) && !empty($_SERVER['REQUEST_URI'])) {
            $route = $_SERVER['REQUEST_URI'];
        }

        //if has route
        if (!empty($route)) {
            if (!empty($this->routes)) {
                $found = false;
                foreach ($this->routes as $routeName => $routeArray) {
                    $searchRoute = $routeArray['url'];
                    if (strpos($route, $searchRoute) === 0) {
                        $found = true;
                        break;//stops search
                    }
                }
                //route found? lets get the params
                if ($found) {
                    $return = array('routeName' => $routeName, 'params' => array(), 'route' => $routeArray);
                    $params = array();
                    $tmp_params = array_chunk(array_filter(explode('/', str_replace($searchRoute, '', $route))), 2);
                    if (!empty($tmp_params)) {
                        foreach ($tmp_params as $value) {
                            $params[$value[0]] = isset($value[1]) ? $value[1] : '';
                        }
                        //here we have the params
                        $return['params'] = $params;
                    }
                }
            }
        }
        return $return;
    }

    /**
     * Redirect to an route, if routename not found redirect directly to it (assuming its an external url)
     *
     * @param $routeName
     * @param array $params
     * @param bool $permanent
     */
    public function redirect($routeName, $params = array(), $permanent = false)
    {
        $url = $routeName;
        if (isset($this->routes[$routeName])) {
            $url = $this->routeToUrl($routeName, $params);
        }

        if (headers_sent()) {//if header alread sent do a ugly js redirect, with no script option to browser with no js support
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . $url . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
            echo '</noscript>';
            exit;
        } else {
            header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
            exit;
        }
    }

    /**
     * Converts a route to url
     *
     * @param $routeName
     * @param array $params
     * @return string url
     * @throws \Exception
     */
    public function routeToUrl($routeName, $params = array())
    {
        $route = $this->check($routeName, $params);
        $url[] = $route['url'];
        if (isset($route['params'])) {
            foreach ($route['params'] as $index => $value) {
                if (!empty($params[$index])) { //try passed params values
                    $url[] = $index;
                    $url[] = $params[$index];
                } else if (!empty($value)) { //try default route values
                    $url[] = $index;
                    $url[] = $value;
                }
            }
        }
        return implode('/', $url);
    }

    /**
     * Simple check if route is valid, returns a boolean
     * Attention: We only validate params if configured, otherwise it passes
     *
     * @param $routeName
     * @param array $params
     * @return bool
     */
    public function isValid($routeName, $params = array())
    {
        $valid = true;
        try {
            $this->check($routeName, $params);
        } catch (\Exception $e) {
            $valid = false;
        }
        return $valid;
    }

    /**
     * Check errors in route, return the route array if its ok
     * Attention: We only validate params if configured, otherwise it passes
     *
     * @param $routeName
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function check($routeName, $params = array())
    {
        if (isset($this->routes[$routeName])) {
            if (isset($this->routes[$routeName]['url'])) {
                if (isset($this->routes[$routeName]['Module'])) {
                    if (isset($this->routes[$routeName]['Controller'])) {
                        if (isset($this->routes[$routeName]['Action'])) {
                            //check parameters passed (only if configured)
                            if (!empty($params) && isset($this->routes[$routeName]['params'])) {
                                foreach ($params as $index => $value) {
                                    if (!isset($this->routes[$routeName]['params'][$index])) {
                                        throw new \Exception('ERROR - Parameter "' . $index . '" not found for route "' . $routeName . '"', 8);
                                    }
                                }
                            }
                            return $this->routes[$routeName];
                        } else {
                            throw new \Exception('ERROR - "Action" param not found for route "' . $routeName . '"', 7);
                        }
                    } else {
                        throw new \Exception('ERROR - "Controller" param not found for route "' . $routeName . '"', 6);
                    }
                } else {
                    throw new \Exception('ERROR - "Module" param not found for route "' . $routeName . '"', 5);
                }
            } else {
                throw new \Exception('ERROR - "url" param not found for route "' . $routeName . '"', 4);
            }
        } else {
            throw new \Exception('ERROR - Route "' . $routeName . '" not found', 3);
        }
    }
}