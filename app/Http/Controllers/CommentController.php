<?php

namespace App\Http\Controllers;

use App\CommentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function doCreate()
    {
        $commentInput = request()->input('comment');
        $id = request()->input('id_post');

        $commentId = DB::table('comments')->insertGetId([
            'id_post' => $id,
            'comment' => $commentInput,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        if ($commentId > 0) {
            $comment = CommentModel::find($commentId);
            return [
                'success' => true,
                'comment' => $comment,
                'message' => 'Success create comment'
            ];
        }else{
            return [
                'success' => false,
                'message' => 'Failed create comment'
            ];
        }
    }
}
