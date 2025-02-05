<?php

namespace Core;

class Route
{
    private $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
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

    private function run()
    {
        $urlArray = $this->splitUrl();

        foreach ($this->routes as $route) {
            $routeArray = explode('/', $route[0]);
            echo '<br>';
            // print_r($routeArray);

            for($i = 0; $i < count($routeArray); $i++) {
                if(strpos($routeArray[$i], "{") !== false && count($urlArray) == count($routeArray)) {
                    $routeArray[$i] = $urlArray[$i];
                }
                $route[0] = implode('/', $routeArray);
            }

            if ($this->getUrl() == $route[0]) {
                echo '<br>Rota válida';
                echo '<br>';
                echo $this->getUrl();
                echo '<br>';
                echo $route[0];
                break;
            } else {
                echo '<br>Rota inválida';
                echo '<br>';
                echo $this->getUrl();
                echo '<br>';
                echo $route[0];
            }
        }
    }
}