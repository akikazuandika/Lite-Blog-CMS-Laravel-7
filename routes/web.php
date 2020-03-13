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
