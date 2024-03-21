<?php
namespace app\core;

class App{
    private $routes = [];



    public function addRoute($url,$handler){
        $url = preg_replace('/{([^\/]+)}/', '(?<$1>[^\/]+)', $url);
        $this->routes[$url] = $handler;
    }

    public function resolve($url){
        $matches = [];
        foreach ($this->routes as $routePattern => $controllerMethod) {
            if(preg_match("#^$routePattern$#", $url, $matches)){

              
                $namedParams = array_filter($matches,
                    function($key) {
                        return !is_numeric($key);
                    }
                    , ARRAY_FILTER_USE_KEY);

            

                return [$controllerMethod, $namedParams];
            }
        }
        return false;
    }

    function filtered($controllerInstance, $method){

        
        $reflection = new \ReflectionClass($controllerInstance);
        
        $classAttributes = $reflection->getAttributes();
        $methodAttributes = $reflection->getMethod($method)->getAttributes();

        $attributes = array_merge($classAttributes,$methodAttributes);

        foreach ($attributes as $attribute) {
            
            $filter = $attribute->newInstance();
         
            if($filter->redirected()){
                return true;
            }
        }
        return false;
    }


    function __construct(){
    

        $url = $_GET['url'];

        include('app/routes.php');

        [$controllerMethod, $namedParams] = $this->resolve($url);

        if(!$controllerMethod){ return;  }

        [$controller,$method] = explode(',', $controllerMethod);

        $controller = '\app\controllers\\' . $controller;
        $controllerInstance = new $controller();

        if($this->filtered($controllerInstance, $method)){
            return;
        }

        call_user_func_array([$controllerInstance, $method], $namedParams);

    }
}