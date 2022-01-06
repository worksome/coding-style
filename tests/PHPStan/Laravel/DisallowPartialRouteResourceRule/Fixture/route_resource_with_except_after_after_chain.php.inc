<?php

use Illuminate\Support\Facades\Route;

Route::resource('foo', 'FooController')->shallow()->except(['show']);
