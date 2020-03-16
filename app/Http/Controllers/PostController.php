<?php

namespace App\Http\Controllers;

use App\CategoryModel;
use App\PostModel;
use App\TagModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostController extends Controller
{
    public function index()
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
            'title' => 'List Post',
            'name' => session('admin.name'),
            'posts' => $posts
        ];
        return view('admin.posts.list', $data);
    }

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
        DB::beginTransaction();

        try {
            $postId = DB::table('posts')->insertGetId([
                "id_category" => request()->category,
                "title" => request()->title,
                "slug" => request()->slug,
                "thumbnail" => request()->thumbnail,
                "content" => request()->content,
                "is_public" => request()->publish,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            $dataInputTags = [];
            foreach (request()->tags as $item) {
                $tempData = [
                    'id_post' => $postId,
                    'id_tag' => $item,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ];
                array_push($dataInputTags, $tempData);
            };
            DB::table('post_tags')->insert($dataInputTags);
            DB::commit();
            return [
                "success" => true,
                "message" => "Success create post"
            ];
        } catch (\Exception $e) {
            return [
                "success" => false,
                "error" => $e
            ];
            DB::rollback();
        }
    }
}
