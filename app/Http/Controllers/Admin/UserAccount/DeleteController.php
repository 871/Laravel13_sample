<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\UserAccount;

use App\Http\Controllers\Controller;
use App\Application\Controller\Admin\UserAccount\Delete;
use App\Security\Auth\AuthContextResolver;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function index(Request $request, $user_account_id)
    {
        abort(405);
    }

    public function indexPost(Request $request, $user_account_id)
    {
        (new Delete(
            datetime: new \DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)    
        ))->delete();

        return redirect()->route(
            'admin.user_account.search.index',
            [
                ...$request->query(),
                'account_id' => $request->route('account_id'),
            ]
        )->with('success', 'ユーザーアカウントの削除が完了しました。');
    }
}
