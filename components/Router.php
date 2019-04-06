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
        
        foreach ($this->routes as $urlPattern => $path) {
            if(preg_match("~$urlPattern~", $uri)){
                $internalRoute = preg_replace("~$urlPattern~", $path, $uri);
                //Utils::debug($path);
                $segments = explode("/", $internalRoute);
                //Utils::debug($segments);
                $controllerName = ucfirst(array_shift($segments))."Controller";
                
                $actionName = "action".ucfirst(array_shift($segments));  
                //Utils::debug(['Controller' => $controllerName, 'Action' => $actionName]);
                $params = $segments;
                $controllerFile = ROOT . "/controllers/" . $controllerName . ".php";
               // Utils::debug($params);
                if(file_exists($controllerFile)){
                    //Utils::debug($controllerFile);
                    include_once($controllerFile);
                    $controllerInstance = new $controllerName;
                    if (call_user_func_array(array($controllerInstance, $actionName), $params)) {
                        return;
                    }
                }                
            }
        }        
    }
}
