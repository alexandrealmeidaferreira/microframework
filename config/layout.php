<?php
/**
 * Layout config file
 * User: alexandre
 * Date: 30/11/15
 * Time: 19:53
 */

return array(
    'layout' => ROOT_DIR . 'layout' . DS . 'index.phtml', //layout for all application
    'Modules' => array(
        'Index' => array(
            'layout' => ROOT_DIR . 'layout' . DS . 'module.phtml', //layout for specific module
            'Controllers' => array(
                'Index' => array(
                    'layout' => ROOT_DIR . 'layout' . DS . 'controller.phtml' //layout for specifc controller
                )
            )
        )
    )
);