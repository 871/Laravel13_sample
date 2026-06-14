<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\AdminAccount;

use App\Http\Controllers\Controller;
use App\Application\Controller\Admin\AdminAccount\Detail;
use App\Security\Auth\AuthContextResolver;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index(Request $request, $admin_account_id)
    {
        $detail = new Detail(
            datetime: new \DateTimeImmutable(), 
            request: $request,
            authContext: AuthContextResolver::resolve($request)
        );

        return view('admin.AdminAccount.detail', [
            'adminAccount' => $detail->getAdminAccount(),
            'adminAccountHistories' => $detail->getAdminAccountHistories(),
        ]);
    }
}
