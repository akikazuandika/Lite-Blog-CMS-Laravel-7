<?php

namespace App\Http\Controllers;

use App\CategoryModel;
use App\TagModel;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        $categories = CategoryModel::get();
        $tags = TagModel::get();
        $data = [
            'title' => 'Create Post',
            'name' => session('admin.name'),
            'categories' => $categories,
            'tags' => $tags
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
