<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 30/11/15
 * Time: 19:51
 */

namespace core;


class Layout
{
    private $layoutFile = 'layout.php';
    private $layouts;

    public function __construct()
    {
        if (is_file(CONFIG_DIR . $this->layoutFile)) {
            $this->layouts = include CONFIG_DIR . $this->layoutFile;
        }
    }

    public function loadLayout($route = false)
    {
        $layout = '';
        if ($route) {
            if (is_array($route)) {
                //check if has default layout for application
                if (isset($this->layouts['layout']) && is_file($this->layouts['layout'])) {
                    $layout = $this->layouts['layout'];
                }
                //check if modules array exists
                if (isset($this->layouts['Modules'])) {
                    //check if module of route has configuration
                    if (isset($this->layouts['Modules'][$route['route']['Module']])) {
                        //check if has a layout for the module
                        if (isset($this->layouts['Modules'][$route['route']['Module']]['layout']) && is_file($this->layouts['Modules'][$route['route']['Module']]['layout'])) {
                            $layout = $this->layouts['Modules'][$route['route']['Module']]['layout'];
                            //check if the controllers array exists
                            if (isset($this->layouts['Modules'][$route['route']['Module']]['Controllers'])) {
                                //check if controller has configuration
                                if (isset($this->layouts['Modules'][$route['route']['Module']]['Controllers'][$route['route']['Controller']])) {
                                    //check if the controller has layout
                                    if (isset($this->layouts['Modules'][$route['route']['Module']]['Controllers'][$route['route']['Controller']]['layout'])
                                        && is_file($this->layouts['Modules'][$route['route']['Module']]['Controllers'][$route['route']['Controller']]['layout'])
                                    ) {
                                        $layout = $this->layouts['Modules'][$route['route']['Module']]['Controllers'][$route['route']['Controller']]['layout'];
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
        if(!empty($layout)){
            include $layout;
        }
    }
}