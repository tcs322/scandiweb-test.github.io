<?php

namespace Core;

use stdClass;

class Route
{
    private $routes;
    
    public function __construct(array $routes)
    {
        $this->routes = $routes;
        $this->setRoutesWithControllerAction();
        $this->run();
    }

    private function getUrl()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    private function splitUrl()
    {
        return explode('/', $this->getUrl());
    }

    private function setRoutesWithControllerAction()
    {
        $this->routes = $this->getControllerAction();
    }

    private function getControllerAction()
    {
        foreach ($this->routes as $route) {
            $controllerNameAndAction = explode('@', $route[1]);
            $routeAndController = [
                $route[0],
                $controllerNameAndAction[0],
                $controllerNameAndAction[1]
            ];

            $routesWithControllerAction[] = $routeAndController; 
        }

        return $routesWithControllerAction;
    }

    private function getRequest()
    {
        $keyAndValueObjectGetRequest = new stdClass;
        $keyAndValueObjectPostRequest = new stdClass;
        $RequestObject = new stdClass;
        
        foreach ($_GET as $key => $value) {
            $keyAndValueObjectGetRequest->$key = $value;
            $RequestObject->get = $keyAndValueObjectGetRequest;
        }

        foreach ($_POST as $key => $value) {
            $keyAndValueObjectPostRequest->$key = $value;
            $RequestObject->post = $keyAndValueObjectPostRequest;
        }

        return $RequestObject;
    }

    private function run()
    {
        $parameters = [];
        $urlArray = $this->splitUrl();

        foreach ($this->routes as $route) {
            $routeArray = explode('/', $route[0]);
            
            for($i = 0; $i < count($routeArray); $i++) {
                if(strpos($routeArray[$i], "{") !== false && count($urlArray) == count($routeArray)) {
                    $routeArray[$i] = $urlArray[$i];
                    $parameters[] = $urlArray[$i];
                }

                $route[0] = implode('/', $routeArray);
            }

            if ($this->getUrl() == $route[0]) {
                $found = true;
                $controller = $route[1];
                $action = $route[2];
                break;
            }
        }

        if ($found) {
            $controller = InitController::newController($controller);
            switch (count($parameters)) {
                case 1:
                    $controller->$action(
                        $parameters[0], 
                        $this->getRequest()
                    );
                    break;
                case 2:
                    $controller->$action(
                        $parameters[0], 
                        $parameters[1],
                        $this->getRequest()
                    );
                    break;
                case 3:
                    $controller->$action(
                        $parameters[0], 
                        $parameters[1], 
                        $parameters[2],
                        $this->getRequest()
                    );
                    break;
                default:
                    $controller->$action($this->getRequest());
            }
        }
    }
}