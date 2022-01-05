<?php

use Illuminate\Support\Facades\Route;

Route::group([], function ($router) {
    $router->resource('foo', 'FooController')->except(['show']);
    $router->resource('bar', 'BarController')->only(['show']);
});

// Some other method call to make sure everything still works
$router->resource('baz', 'BazController');