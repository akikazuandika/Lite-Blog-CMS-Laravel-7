<?php

namespace App\Http\Controllers;

use App\TagModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TagController extends Controller
{
    public function index()
    {
        $tags = TagModel::get();
        $data = [
            'title' => 'List Tag',
            'name' => session('admin.name'),
            'tags' => $tags
        ];
        return view('admin.tags.list', $data);
    }

    public function doCreate()
    {
        $name = request()->input('tag');
        $tagId = DB::table('tags')->insertGetId([
            'tag_name' => $name,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        if ($tagId > 0) {
            $tag = TagModel::find($tagId);
            return [
                'success' => true,
                'tag' => $tag,
                'message' => 'Success create tag'
            ];
        }else{
            return [
                'success' => false,
                'message' => 'Failed create tag'
            ];
        }
    }

    public function edit()
    {
        $id = request()->input('id');
        $tag = request()->input('tag');
        if (!$id) {
            return [
                "success" => false,
                "message" => "invalid data"
            ];
        }
        $findTag = TagModel::find($id);
        if (!$findTag) {
            return [
                "success" => false,
                "message" => "tag not found"
            ];
        }else{
            DB::table('tags')
                ->where('id', $id)
                ->update(['tag_name' => $tag]);
            return [
                "success" => true,
                "message" => "success edit tag"
            ];
        }

    }

    public function delete()
    {
        $id = request()->input('id');
        if (!$id) {
            return [
                "success" => false,
                "message" => "invalid data"
            ];
        }

        $tag = TagModel::find($id);
        if (!$tag) {
            return [
                "success" => false,
                "message" => "tag not found"
            ];
        }else{
            $tag->delete();
            return [
                "success" => true,
                "message" => "Success delete tag"
            ];
        }
    }
}
