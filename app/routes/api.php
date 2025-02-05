<?php

$route[] = ['/', 'HomeController@index'];
$route[] = ['/post', 'PostController@index'];
$route[] = ['/post/{id}/show', 'PostController@show'];


return $route;