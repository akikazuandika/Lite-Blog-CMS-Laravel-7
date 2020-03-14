<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $data = [
            'name' => session('admin.name'),
            'title' => "Home"
        ];
        return view('admin.home', $data);
    }
}
