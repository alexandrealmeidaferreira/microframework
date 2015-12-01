<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 29/11/15
 * Time: 21:00
 */

namespace Index\Controllers;


use core\Debug;

class IndexController
{

    public function indexAction()
    {
        echo "I am in the index!!";
        Debug::dump($_GET);
    }
}