<?php

use Illuminate\Support\Facades\Route;

Route::resource('foo', 'FooController')->only(['show', 'update']);
