<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'PublicController@home');
Route::get('/post/{slug}', 'PublicController@single');

Route::prefix('admin')->group(function(){

    //Unlogged admin
    Route::get('login', 'AdminAuth@login');
    Route::post('doLogin', 'AdminAuth@doLogin');

    //Loggedin admin
    Route::middleware(['isAdmin'])->group(function(){
        Route::get('/', 'AdminController@index');
        Route::get('/logout', 'AdminAuth@doLogout');

        //Posts
        Route::get('/posts', 'PostController@index');
        Route::get('/post/create', 'PostController@create');
        Route::post('/post/doCreate', 'PostController@doCreate');
        Route::post('/post/delete', 'PostController@delete');
        Route::post('/post/check-slug', 'PostController@checkSlug');

        //Image
        Route::post('/image/upload', 'ImageController@upload');
    });
});
