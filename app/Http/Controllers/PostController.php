<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        $data = [
            'title' => 'Create Post',
            'name' => session('admin.name')
        ];
        return view('admin.posts.create', $data);
    }

    public function doCreate()
    {
        return [
            "success" => true
        ];
    }
}
