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

    public function __construct($params = array(), $type = self::HTML)
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
                $this->loadView();
                break;
            case self::JSON;
                //if json just spit back the string in json format
                echo json_encode($params);
                break;
        }
        return $type;
    }


    private function loadView()
    {
        $view = MODULES_DIR . $_GET['Module'] . DS . 'Views' . DS . $_GET['Controller'] . DS . $_GET['Action'] . '.phtml';
        if (is_file($view)) {
            include $view;
        } else {
            die('VIEW NOT FOUND!');
        }
    }

    public function getRenderType()
    {
        return $this->renderType;
    }
}