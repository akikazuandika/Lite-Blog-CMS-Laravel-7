<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload()
    {
        try {
            request()->validate([
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            $imageName = time().'.'.request()->file('file')->getClientOriginalExtension();
            request()->file('file')->move(public_path('images'), $imageName);
            return response([
                "success" => true,
                "url" => url('images'). "/" .$imageName
            ]);
        } catch (\Throwable $th) {
            return response([
                "success" => false,
                "error" => $th
            ]);
        }

    }
}
