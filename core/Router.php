<?php
/**
 * Router class
 *
 * User: alexandre
 * Date: 29/11/15
 * Time: 15:18
 */

namespace core;


class Router
{
    private static $routeFile = 'routes.php';
    private static $routes = array();
    private static $_instance;

    /**
     * Init the router and returns it
     *
     * @return Router
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;

            //get the routes
            if (is_file(CONFIG_DIR . self::$routeFile) && empty(self::$routes)) {
                self::$routes = include CONFIG_DIR . self::$routeFile;
            }
        }

        return self::$_instance;
    }

    /**
     * Match a route from parameter $route or try to get from $_SERVER['REQUEST_URI']
     *
     * @param string $route
     * @return array|bool
     */
    public static function matchRoute($route = '')
    {
        $return = false;
        $request_uri = str_replace('?', '', $_SERVER['REQUEST_URI']);

        //try to get route if none passed as parameter
        if (empty($route) && !empty($request_uri)) {
            $route = $request_uri;
        }

        //if has route
        if (!empty($route)) {
            if (!empty(self::$routes)) {
                $found = false;

                //search for a full route match
                foreach (self::$routes as $routeName => $routeArray) {
                    $searchRoute = $routeArray['url'];
                    if($searchRoute === $route){
                        $found = true;
                        break;//stops search
                    }
                }

                //search for a partial route match
                if(!$found){
                    foreach (self::$routes as $routeName => $routeArray) {
                        $searchRoute = $routeArray['url'];
                        if (strpos($route,$searchRoute) === 0) {
                            $found = true;
                            break;//stops search
                        }
                    }
                }

                //lets get the params
                $return = array(
                    'routeName' => $routeName,
                    'params' => self::getRouteParams($route, $searchRoute),
                    'route' => ($found) ? $routeArray : self::$routes['index-route']
                );
            }
        }

        return $return;
    }

    /**
     * Return params of route
     *
     * @param $route
     * @param $searchRoute
     * @return array
     */
    public static function getRouteParams($route, $searchRoute)
    {
        $params = array();
        $tmp_params = array_chunk(array_filter(
            explode('/', ($searchRoute == '/') ? $route : str_replace($searchRoute, '', $route))
        ), 2);
        if (!empty($tmp_params)) {
            foreach ($tmp_params as $value) {
                $params[$value[0]] = isset($value[1]) ? $value[1] : '';
            }
        }
        return $params;
    }

    /**
     * Redirect to an route, if routename not found redirect directly to it (assuming its an external url)
     *
     * @param $routeName
     * @param array $params
     * @param bool $permanent
     */
    public static function redirect($routeName, $params = array(), $permanent = false)
    {
        $url = $routeName;
        if (isset(self::$routes[$routeName])) {
            $url = self::routeToUrl($routeName, $params);
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
    public static function routeToUrl($routeName, $params = array())
    {
        try {
            $route = self::check($routeName, $params);
            if ($route) {
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
        } catch (\Exception $e) {
            //route not found
        }
    }

    /**
     * Simple check if route is valid, returns a boolean
     * Attention: We only validate params if configured, otherwise it passes
     *
     * @param $routeName
     * @param array $params
     * @return bool
     */
    public static function isValid($routeName, $params = array())
    {
        $valid = true;
        try {
            self::check($routeName, $params);
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
    public static function check($routeName, $params = array())
    {
        if (isset(self::$routes[$routeName])) {
            if (isset(self::$routes[$routeName]['url'])) {
                if (isset(self::$routes[$routeName]['Module'])) {
                    if (isset(self::$routes[$routeName]['Controller'])) {
                        if (isset(self::$routes[$routeName]['Action'])) {
                            //check parameters passed (only if configured)
                            if (!empty($params) && isset(self::$routes[$routeName]['params'])) {
                                foreach ($params as $index => $value) {
                                    if (!isset(self::$routes[$routeName]['params'][$index])) {
                                        throw new \Exception('ERROR - Parameter "' . $index . '" not found for route "' . $routeName . '"', 8);
                                    }
                                }
                            }
                            return self::$routes[$routeName];
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

    /**
     * Check if passed route is the current route
     *
     * @param string $url
     * @return bool
     */
    public static function isCurrentRoute($url = '')
    {
        $isCurrentRoute = false;
        $route = self::matchRoute($url);
        if ($route['route']['Module'] == $_GET['Module'] &&
            $route['route']['Controller'] == $_GET['Controller'] &&
            $route['route']['Action'] == $_GET['Action']
        ) {
            $isCurrentRoute = true;
        }
        return $isCurrentRoute;
    }
}