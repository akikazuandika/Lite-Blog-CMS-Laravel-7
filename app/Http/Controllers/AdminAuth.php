<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuth extends Controller
{
    public function __construct() {

    }

    public function doLogin()
    {
        $response = [
            "status" => true
        ];
        return response($response);
    }
}
