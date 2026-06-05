<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopController extends Controller
{
    public function index(Request $request, $account_id = null)
    {
        return view('admin.top');
    }

    public function errorTest(Request $request, $account_id = null)
    {
        // Intentionally throw to test error handling
        throw new \RuntimeException('Admin TopController errorTest triggered');
    }
}
