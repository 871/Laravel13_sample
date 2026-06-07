<?php

declare(strict_types=1);

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Security\Auth\AuthSession;
use App\Security\Auth\AuthContext\Fields\Type;
use App\Security\Input\StrictCast;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // route param account_id -> strict string
        $accountId = StrictCast::toString($request->route('account_id'));

        $authSession = new AuthSession(
            request: $request,
            type: Type::TYPE_ADMIN,
            account_id: $accountId,
        );

        if (!$authSession->check()) {
            // Keep CakePHP flash structure so existing code reading it stays compatible
            $request->session()->put('Flash.flash', [
                [
                    'message' => 'ログアウトしました。',
                    'key' => 'flash',
                    'element' => 'Flash/error',
                    'params' => [],
                ],
            ]);

            return redirect()->to('/v1/ad/login?redirect=' . urlencode($request->getRequestUri()));
        }

        return $next($request);
    }
}
