<?php

namespace App\Http\Controllers;

use App\PostModel;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $perpage = request()->query('perpage', 10);
        $posts = PostModel::paginate($perpage);

        foreach ($posts as $item) {
            $category = PostModel::find($item->id)->category;
            $tags = PostModel::find($item->id)->tags;
            $item->category = $category;
            $item->tags = $tags;
        }
        $data = [
            'title' => "Home",
            'posts' => $posts
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
