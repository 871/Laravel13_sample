<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin\Api;

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
    /**
     * Handle API login (expects JSON request)
     */
    public function index(Request $request)
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

            return response()->json(["ok" => true, "redirect" => $redirect]);
        } catch (AuthException $e) {
            // brute force対策
            sleep(3);
            return response()->json(["ok" => false, "message" => $e->getMessage()], 401);
        } catch (\Throwable $e) {
            Log::error('Admin API Login Error', ['exception' => $e]);
            return response()->json(["ok" => false, "message" => '予期せぬエラーが発生しました'], 500);
        }
    }
}
