<?php

use Core\Route;

$routes = require_once __DIR__ . "/../app/routes/api.php";
$route = new Route($routes);