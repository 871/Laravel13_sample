<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $app = new \App\Application\Controller\Admin\Login();

        return $app->show();
    }

    public function indexPost(Request $request)
    {
        $app = new \App\Application\Controller\Admin\Login();

        return $app->authenticate($request);
    }
}
