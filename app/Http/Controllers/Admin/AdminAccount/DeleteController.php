<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\AdminAccount;

use App\Http\Controllers\Controller;
use App\Application\Controller\Admin\AdminAccount\Delete as CtlService;
use App\Security\Auth\AuthContextResolver;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function index(Request $request, $admin_account_id)
    {
        abort(405);
    }

    public function indexPost(Request $request, $admin_account_id)
    {
        $service = new CtlService(new \DateTimeImmutable(), $request, AuthContextResolver::resolve($request));
        $service->delete();

        return redirect()->route('admin.admin_account.index', ['account_id' => $request->route('account_id')])->with('success', '管理者アカウントの削除が完了しました。');
    }
}
