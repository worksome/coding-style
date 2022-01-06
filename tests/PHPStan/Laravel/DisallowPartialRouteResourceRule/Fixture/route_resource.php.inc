<?php

use Illuminate\Support\Facades\Route;

/**
 * All the following examples should be allowed
 * as they are not partial route resources.
 */

Route::resource('foo', 'FooController');

Route::resource('bar', 'BarController')->shallow();

Route::apiResource('baz', 'BazController');

Route::apiResource('bam', 'BamController')->shallow();

Route::resource('qux', 'QuxController')->names([
    'index' => 'qux.list'
]);

Route::resource('blogs', 'BlogController')->parameters([
    'blogs' => 'post'
]);

Route::resource('photos.comments', 'PhotoCommentController')->scoped([
    'comment' => 'slug',
]);

Route::group([], function ($router) {
    $router->resource('photos', 'PhotoController')->scoped();
    $router->apiResource('books', 'BookController')->scoped();
});
