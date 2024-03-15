<?php
namespace app\core;

class App
{
    private $routes = [];

    public function addRoute($url, $handler)
    {
        $url = preg_replace('/{([^\/]+)}/', '(?<$1>[^\/]+)', $url);
        $this->routes[$url] = $handler;
    }

    //defined a few routes "url"=>"controller,method"
    public function __construct()
    {
        $url = $_GET['url'];

        //defined a few routes "url"=>"controller,method"
        $routes = [
            'Main/' => 'Contact,mainIndex',
            'Main/about_us' => 'Contact,mainAboutUs',
            'Contact/index' => 'Contact,contactIndex',
            'Contact/read' => 'Contact,contactRead',
            'Contact/send' => 'Contact,send'
        ];

        //one by one compare the url to resolve the route
        foreach ($routes as $routeUrl => $controllerMethod) {
            if ($url == $routeUrl) {//match the route
                //run the route
                [$controller, $method] = explode(',', $controllerMethod);
                $controller = '\\app\\controllers\\' . $controller;
                $controller = new $controller();
                $controller->$method();
                //make sure that we don't run a second route
                break;
            }
        }
    }
}