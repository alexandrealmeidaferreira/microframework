<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 29/11/15
 * Time: 21:00
 */

namespace Index\Controllers;


use core\Controller;
use core\Debug;
use core\View;

class IndexController extends Controller
{

    public function indexAction()
    {

        return new View(array(
            'variable1' => 'v1',
            'variable2' => 'v2'
        ));
    }

    public function libraryAction()
    {
        return new View();
    }


    /**
     * Action for test json functionality
     *
     * @return View
     */
    public function jsonTestAction()
    {

        return new View(array(
            'variable1' => 'v1',
            'variable2' => 'v2',
            'jsonValue' => 'okey!'
        ), View::JSON);
    }
}