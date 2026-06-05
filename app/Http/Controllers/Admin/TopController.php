<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopController extends Controller
{
    public function index(Request $request, $account_id = null)
    {
        $admin = session('admin_user');

        if (!$admin) {
            return redirect('/v1/ad/login')->with('error', 'ログインしてください。');
        }

        // If account_id is provided, ensure it matches session (best-effort)
        if ($account_id !== null && (string)($admin['id'] ?? '') !== (string)$account_id) {
            // allow but warn via flash
            session()->flash('warning', '現在のセッションとパラメータが一致しません。');
        }

        return view('admin.top.index', ['admin' => $admin]);
    }

    public function errorTest(Request $request, $account_id = null)
    {
        // Intentionally throw to test error handling
        throw new \RuntimeException('Admin TopController errorTest triggered');
    }
}
