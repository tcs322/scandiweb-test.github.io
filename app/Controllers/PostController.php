<?php

namespace App\Controllers;

use stdClass;

class PostController
{
    public function index()
    {
        echo "Index Posts";
    }

    public function show(string $id, $request)
    {
        echo $id;
        echo '<br>';
        echo $request->get->name;
        echo '<br>';
        echo $request->get->email;
        echo '<br>';
    }
}