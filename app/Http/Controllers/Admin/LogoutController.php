<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function index(Request $request, $account_id = null)
    {
        // perform logout
        $this->doLogout($request);
        return redirect('/v1/ad/login')->with('success', 'ログアウトしました。');
    }

    public function indexPost(Request $request, $account_id = null)
    {
        $this->doLogout($request);
        return redirect('/v1/ad/login')->with('success', 'ログアウトしました。');
    }

    protected function doLogout(Request $request): void
    {
        // remove admin session
        $request->session()->forget('admin_user');
        // also flush entire session except CSRF token? keep simple
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
    }
}
