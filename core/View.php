<?php
/**
 * Control the view
 *
 * User: alexandre
 * Date: 01/12/15
 * Time: 22:01
 */

namespace core;


class View
{

    const HTML = 1;
    const JSON = 2;

    private $renderType;

    /**
     * Initiate the class
     *
     * @param array $params
     * @param int $type
     * @param string $customView
     */
    public function __construct($params = array(), $type = self::HTML, $customView = '')
    {
        $this->renderType = $type;
        switch ($type) {
            default:
            case self::HTML:
                //pass the variables to view
                if (!empty($params)) {
                    foreach ($params as $index => $value) {
                        $this->$index = $value;
                    }
                }

                //load the view
                $this->loadView($customView);
                break;
            case self::JSON;
                //if json just spit back the string in json format
                echo json_encode($params);
                break;
        }
        return $type;
    }

    /**
     * Load an view
     *
     * @param string $customView
     */
    private function loadView($customView = '')
    {
        $view = (empty($customView)) ? MODULES_DIR . $_GET['Module'] . DS . 'Views' . DS . $_GET['Controller'] . DS . $_GET['Action'] . '.phtml' : $customView;
        if (is_file($view)) {
            $this->loadCss();
            $this->loadJs();
            include $view;
        } else {
            die('VIEW NOT FOUND!');
        }
    }

    /**
     * Load a js that matches the route
     */
    private function loadJs()
    {
        $js = $_GET['Module'] . '/' . $_GET['Controller'] . '/' . $_GET['Action'] . '.js';
        if (is_file(JS_DIR . $js))
            Layout::appendJs('js/' . $js);
    }

    /**
     * Load a css that matches the route
     */
    private function loadCss()
    {
        $css = $_GET['Module'] . DS . $_GET['Controller'] . DS . $_GET['Action'] . '.css';
        if (is_file(JS_DIR . $css))
            Layout::appendJs('js/' . $css);
    }

    /**
     * Return the render type
     *
     * @return int
     */
    public function getRenderType()
    {
        return $this->renderType;
    }

    /**
     * Make an valid url
     *
     * @param $routeName
     * @param array $params
     * @return string
     */
    public function url($routeName, $params = array())
    {
        return Router::getInstance()->routeToUrl($routeName, $params);
    }
}