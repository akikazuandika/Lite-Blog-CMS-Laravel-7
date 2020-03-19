<?php

namespace App\Http\Controllers;

use App\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = CategoryModel::get();
        // return $categories;
        $data = [
            'title' => 'List Category',
            'name' => session('admin.name'),
            'categories' => $categories
        ];
        return view('admin.categories.list', $data);
    }

    public function doCreate()
    {
        $name = request()->input('category');
        $categoryId = DB::table('categories')->insertGetId([
            'category_name' => $name,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        if ($categoryId > 0) {
            $category = CategoryModel::find($categoryId);
            return [
                'success' => true,
                'category' => $category,
                'message' => 'Success create category'
            ];
        }else{
            return [
                'success' => false,
                'message' => 'Failed create category'
            ];
        }
    }

    public function edit()
    {
        $id = request()->input('id');
        $category = request()->input('category');
        if (!$id) {
            return [
                "success" => false,
                "message" => "invalid data"
            ];
        }
        $findCategory = CategoryModel::find($id);
        if (!$findCategory) {
            return [
                "success" => false,
                "message" => "category not found"
            ];
        }else{
            DB::table('categories')
                ->where('id', $id)
                ->update(['category_name' => $category]);
            return [
                "success" => true,
                "message" => "success edit category"
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

        $category = CategoryModel::find($id);
        if (!$category) {
            return [
                "success" => false,
                "message" => "category not found"
            ];
        }else{
            $category->delete();
            return [
                "success" => true,
                "message" => "Success delete category"
            ];
        }
    }
}
