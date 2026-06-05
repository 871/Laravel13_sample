<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Application\Controller\Admin\Login as CtlApp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Security\Auth\AuthContextResolver;
use App\Security\Input\StrictCast;
use App\Exception\AuthException;
use Carbon\CarbonImmutable;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.login');
    }

    public function indexPost(Request $request)
    {
        try {
            $ctlApp = new CtlApp(
                datetime: CarbonImmutable::now(),
                request: $request,
                authContext: AuthContextResolver::resolve($request),
            );

            $redirect = $ctlApp
                ->login(
                    login_id: StrictCast::toString($request->input('email')),
                    password: StrictCast::toString($request->input('password')),
                )
                ->recordLoginSuccess()
                ->getRedirect();

            return redirect()->to($redirect);
        } catch (AuthException $e) {
            sleep(3); // brute force対策
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Admin Login Error', ['exception' => $e]);
            return back()
                ->withInput()
                ->with('error', '予期せぬエラーが発生しました');
        }
    }
}
