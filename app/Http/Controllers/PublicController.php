<?php

namespace App\Http\Controllers;

use App\PostModel;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $data = [
            'title' => "Home"
        ];
        return view('public.home', $data);
    }

    public function single($slug)
    {
        $post = PostModel::where('slug', $slug)->get();
        if (count($post) == 0) {
            abort(404);
        }else{
            $data = [
                'title' => $slug,
                'post' => $post->first()
            ];
            return view('public.detail-post', $data);
        }
    }
}
