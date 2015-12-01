<?php
/**
 * Config routes of application
 * User: alexandre
 * Date: 29/11/15
 * Time: 16:12
 */

return array(
    'index-route' => array(
        'url' => '/',
        'Module' => 'Index',
        'Controller' => 'Index',
        'Action' => 'index'
    ),

    'home-route' => array(
        'url' => '/home',
        'Module' => 'Index',
        'Controller' => 'Index',
        'Action' => 'index'
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
    )

);