<?php

require 'aplication/lib/Dev.php';

use aplication\core\Router;

spl_autoload_register(function($class){
    // echo '<p>'.$class.'</p>';
    $path = str_replace('\\', '/', $class.'.php');
    if(file_exists($path)){
      //  echo $path.'<br>';
        require $path;
    }
});
//echo phpinfo();
session_start();

$router = new Router;
$router->run();