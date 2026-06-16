<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\UserAccount;

use App\Http\Controllers\Controller;
use App\Application\Controller\Admin\UserAccount\Detail;
use App\Security\Auth\AuthContextResolver;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index(Request $request, $user_account_id)
    {
        $detail = new Detail(
            datetime: new \DateTimeImmutable(), 
            request: $request,
            authContext: AuthContextResolver::resolve($request)
        );

        return view('admin.UserAccount.detail', [
            'userAccount' => $detail->getUserAccount(),
            'userAccountHistories' => $detail->getUserAccountHistories(),
        ]);
    }
}
