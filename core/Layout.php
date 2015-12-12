<?php
/**
 * Controls all layouts
 *
 * User: alexandre
 * Date: 30/11/15
 * Time: 19:51
 */

namespace core;


class Layout
{
    private static $layoutFile = 'layout.php';
    private static $layouts;
    private static $_instance;
    private static $js = array();
    private static $css = array();

    /**
     * @return Layout
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;

            //get the routes
            if (is_file(CONFIG_DIR . self::$layoutFile) && empty(self::$layouts)) {
                self::$layouts = include CONFIG_DIR . self::$layoutFile;
            }
        }

        return self::$_instance;
    }

    public static function loadLayout($route = false)
    {
        $layout = '';
        if ($route) {
            if (is_array($route)) {
                //check if has default layout for application
                if (isset(self::$layouts['layout']) && is_file(self::$layouts['layout'])) {
                    $layout = self::$layouts['layout'];
                }
                //check if modules array exists
                if (isset(self::$layouts['Modules'])) {
                    //check if module of route has configuration
                    if (isset(self::$layouts['Modules'][$route['route']['Module']])) {
                        //check if has a layout for the module
                        if (isset(self::$layouts['Modules'][$route['route']['Module']]['layout']) && is_file(self::$layouts['Modules'][$route['route']['Module']]['layout'])) {
                            $layout = self::$layouts['Modules'][$route['route']['Module']]['layout'];
                            //check if the controllers array exists
                            if (isset(self::$layouts['Modules'][$route['route']['Module']]['Controllers'])) {
                                //check if controller has configuration
                                if (isset(self::$layouts['Modules'][$route['route']['Module']]['Controllers'][$route['route']['Controller']])) {
                                    //check if the controller has layout
                                    if (isset(self::$layouts['Modules'][$route['route']['Module']]['Controllers'][$route['route']['Controller']]['layout'])
                                        && is_file(self::$layouts['Modules'][$route['route']['Module']]['Controllers'][$route['route']['Controller']]['layout'])
                                    ) {
                                        $layout = self::$layouts['Modules'][$route['route']['Module']]['Controllers'][$route['route']['Controller']]['layout'];
                                    }
                                }
                            }
                        }
                    }
                }
            } else if (is_string($route) && is_file($route)) {
                //if the route is a string it should be an path to custom layout
                $layout = $route;
            }
        }

        //after all validation has a layout? then include safety
        if (!empty($layout)) {
            include $layout;
        }
    }

    /**
     * Append a js to layout
     *
     * @param $js
     * @return Layout
     */
    public static function appendJs($js)
    {
        if (is_array($js)) {
            self::$js = array_merge($js, self::$js);
        } else {
            self::$js[] = $js;
        }

        return self::$_instance;
    }

    /**
     * Return all javascripts
     *
     * @return string
     */
    public static function outputJavascript()
    {
        $arr = array();
        foreach (self::$js as $js) {
            $arr[] = '<script src="' . $js . '"></script>';
        }
        return implode("\n", $arr);
    }

    /**
     * Append a css to layout
     *
     * @param $css
     * @return Layout
     */
    public static function appendCss($css)
    {
        if (is_array($css)) {
            self::$css = array_merge($css, self::$css);
        } else {
            self::$css[] = $css;
        }

        return self::$_instance;
    }

    /**
     * Return all stylesheets
     *
     * @return string
     */
    public static function outputStylesheet()
    {
        $arr = array();
        foreach (self::$css as $css) {
            $arr[] = '<link rel="stylesheet" href="' . $css . '">';
        }
        return implode("\n", $arr);
    }
}