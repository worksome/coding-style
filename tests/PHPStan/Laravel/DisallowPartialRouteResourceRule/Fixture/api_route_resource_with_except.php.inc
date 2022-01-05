<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('foo', 'FooController')->except(['show']);
