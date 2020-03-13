<?php

namespace App\Http\Controllers;

use App\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuth extends Controller
{
    public function __construct() {

    }

    public function doLogin(Request $request)
    {
        try {
            $admin = AdminModel::where('username', $request->username)->get();
            if (count($admin) == 0) {
                $res = [
                    "success" => false,
                    "code" => 404,
                    "message" => "Not found"
                ];
                return response($res);
            }else{
                $admin = $admin[0];
                if (Hash::check($request->password, $admin->password)) {
                    $res = [
                        "success" => true,
                        "data" => $admin
                    ];
                    $session = [
                        'username' => $admin->username,
                        'level' => $admin->level,
                        'name' => $admin->name,
                    ];
                    session(['admin' => $session]);
                    return response($res);
                }else{
                    $res = [
                        "success" => false,
                        "code" => 401,
                        "message" => "Unauthorized"
                    ];
                    return response($res);
                }
            }
        } catch (\Throwable $th) {
            return [
                "success" => false,
                "error" => $th
            ];
        }
    }

    public function doLogout(Request $request)
    {
        $request->session()->flush();
        return redirect("admin/login");
    }
}
