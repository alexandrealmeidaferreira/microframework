<?php
/**
 * Controller class
 *
 * User: alexandre
 * Date: 01/12/15
 * Time: 22:16
 */

namespace core;


class Controller
{
    /**
     * Check if is post
     *
     * @return bool
     */
    public function isPost()
    {
        return !empty($_POST);
    }

    /**
     * Return all post values if parameter is not passed, or match the variable
     *
     * @param string $var
     * @return array
     */
    public function getPost($var = '')
    {
        $variables = array();
        if (!empty($var) && isset($_POST[$var])) {
            $variables = $_POST[$var];
        } else if (empty($var)) {
            $variables = $_POST;
        }
        return $variables;
    }

    /**
     * Return all get values if parameter is not passade, or match the variable
     *
     * @param string $var
     * @return array
     */
    public function getGet($var = '')
    {
        $variables = array();
        if (!empty($var) && isset($_GET[$var])) {
            $variables = $_GET[$var];
        } else if (empty($var)) {
            $variables = $_GET;
        }
        //remove unnecessary parameters
        if (isset($variables['Module']))
            unset($variables['Module']);
        if (isset($variables['Controller']))
            unset($variables['Controller']);
        if (isset($variables['Action']))
            unset($variables['Action']);

        return $variables;
    }

    /**
     * Return all params GET and POST
     *
     * @return array
     */
    public function getParams()
    {
        return array_merge($this->getGet(), $this->getPost());
    }
}