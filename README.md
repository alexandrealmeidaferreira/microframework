# MicroFramework
A simple framework build from scratch, it is for my personal use, but feel free to use and modify it for your applications and needs.   

Developer: Alexandre Almeida Ferreira   
E-mail: alexandrealmeidaferreira@gmail.com   

##CHANGE LOG
###2015-12-24 - version 0.3   
Added /core/FlashMesseger.php it help to create messages between pages, can render in bootstrap alert format
Added /js/microframework.js suport to auto close a alert message

###2015-12-24 - version 0.3   
Added redirect to Controller class   
Added toSetUpdatePDO to SimpleObject to help create an UPDATE statement   

###2015-12-19 - version 0.3
Added support to disable layout in /core/Layout.php   
Added disableLayout in Controller class, to disable layout in current action   

###2015-12-12 - version 0.2
Added /core/Model/SimpleObject.php   
Improved auto load of classes, now is possible to set an path in config/autoloader.php   
Improved Layout, now we can add css and javascript in code   
Improved View   
Added js and css default files in public/{js, css}/\<MODULE\>/\<CONTROLLER\>/\<ACTION\>.{js, css}   

###2015-12-09
Added /core/Db.php   
Added /config/*.database.php   

Db add a pool of PDO connections   

###2015-12-01 - version 0.1
Added /core/View.php   


###2015-11-29
Started the project   
Created /index.php   
Created /config/routes.php   
Created /config/autoloader.php   
Created /core/Application.php   
Created /core/Debug.php   
Created /core/Router.php   

Application add a simple autoloader   
Router add a simple router   
Debug add a simple debug   
