<?php

namespace aplication\core;

 class View {
    
    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route){
        $this->route = $route;
        $this->path = $route['controller'].'/'.$route['action'];
    }

    public function render($title, $vars = []){
        extract($vars);
       
        $path =  'aplication/views/'.$this->path.'.php';
        if(file_exists($path)){
            ob_start();
         require  $path;
         $content = ob_get_clean();
         //echo $title;
        // var_dump($title);
         require  'aplication/views/layouts/'.$this->layout.'.php';  
        }
    }

 public function redirect($url){
       header('location: /'.$url);
        exit;
    }

    public static function errorCode($code){
        http_response_code($code);
        $path = 'aplication/views/errors/'.$code.'.php';
        if(file_exists($path)){
             require $path;
        exit;
        }
    }
    public function massage($status, $massage){
         exit(json_encode(['status'=>$status, 'massage'=>$massage]));
    }
    
    public function location($url){
        exit(json_encode(['url'=>$url]));
    }
}