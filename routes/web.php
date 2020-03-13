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
    Route::get('login', function () {
        return view('admin.login');
    });

    Route::post('doLogin', 'AdminAuth@doLogin');

    //Loggedin admin
    Route::middleware(['isAdmin'])->group(function(){
        Route::get('/', function () {
            echo "Hello admin";
        });
    });
});
