<?php
/**
 * Config routes of application
 * The application get a route trying to match then, its important the / route be the last to not overwrite other!
 *
 * User: alexandre
 * Date: 29/11/15
 * Time: 16:12
 */

return array(

    'home-route' => array(
        'url' => '/home',
        'Module' => 'Index',
        'Controller' => 'Index',
        'Action' => 'index'
    ),

    //library route (test)
    'library-route' => array(
        'url' => '/library',
        'Module' => 'Index',
        'Controller' => 'Index',
        'Action' => 'library'
    ),

    //an json test
    'json-test-route' => array(
        'url' => '/json-test',
        'Module' => 'Index',
        'Controller' => 'Index',
        'Action' => 'jsonTest'
    ),

    'test-route' => array(
        'url' => '/test-route',
        'Module' => 'Index',
        'Controller' => 'Index',
        'Action' => 'index',
        'params' => array(
            'page' => 1,
            'id' => 999,
            'teste' => 'ok',
            'empty' => ''
        )
    ),

    'test-route2' => array(
        'url' => '/teste/my/strange-route',
        'Module' => 'Index',
        'Controller' => 'Index',
        'Action' => 'index',
        'params' => array(
            'page' => 1,
            'id' => 999,
            'teste' => 'ok',
            'empty' => ''
        )
    ),
    //root route
    //important the / route be the last ok!
    'index-route' => array(
        'url' => '/',
        'Module' => 'Index',
        'Controller' => 'Index',
        'Action' => 'index'
    ),

);