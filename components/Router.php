<?php

/**
 * Description of Router
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class Router {
    private $routes;
    
    public function __construct() {
        $routePath = ROOT.'/config/routes.php';
        $this->routes = include($routePath);
    }
    
    private function getURI(){
        $requestURI = filter_input(INPUT_SERVER, 'REQUEST_URI');
        if(!empty($requestURI)){
            $requestURI = trim($requestURI, '/');
        }
        return $requestURI;
    }
    
    public function run(){
        //debug($this->routes);
        $uri = $this->getURI();
        echo "URI = ".$uri."<br />";
        foreach ($this->routes as $urlPattern => $path) {
            if(preg_match("~$urlPattern~", $uri)){
                $segments = explode("/", $uri);
                $controllerName = ucfirst(array_shift($segments))."Controller";
                $actionName = "action".ucfirst(array_shift($segments));  
                $params = $segments;
                echo "Класс контроллера: ".$controllerName."<br />";
                echo "Имя метода: ".$actionName."<br />";
                $controllerFile = ROOT . "/controllers/" . $controllerName . ".php";
                echo "Файл контроллера: " . $controllerFile;
                if(file_exists($controllerFile)){
                    include_once($controllerFile);
                    $controllerInstance = new $controllerName;
                    $res = call_user_func($controllerInstance->$actionName, $params);
                    if($res){
                        return;
                    }
                }
                
            }
        }
        
    }
}
