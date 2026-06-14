<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\AdminAccount;

use App\Http\Controllers\Controller;
use App\Application\Controller\Admin\AdminAccount\Delete;
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
        $delete = new Delete(
            datetime: new \DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)    
        );
        $delete->delete();

        return redirect()->route(
            'admin.admin_account.search.index',
            [
                'account_id' => $request->route('account_id'),
                ...$request->query(),
            ]
        )->with('success', '管理者アカウントの削除が完了しました。');
    }
}
