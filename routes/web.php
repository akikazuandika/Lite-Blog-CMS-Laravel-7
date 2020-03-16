<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $data = [
        'title' => "Home"
    ];
    return view('public.home', $data);
});

Route::get('/post/{slug}', function ($slug) {
    $data = [
        'title' => $slug
    ];
    return view('public.detail-post', $data);
});

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
