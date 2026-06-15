<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\AdminAccount;

use App\Http\Controllers\Controller;
use App\Application\Controller\Admin\AdminAccount\Search;
use App\Security\Auth\AuthContextResolver;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function init(Request $request)
    {
        $search = new Search(
            datetime: new \DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        return redirect()->action([
                self::class,
                'index',
            ], [
                'account_id' => $request->route('account_id'),
                ...$search->getInitParams()
            ],
        );
    }

    public function index(Request $request)
    {
        $search = new Search(
            datetime: new \DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        return view(
            'admin.AdminAccount.search',
            [
                'searchResults' => $search->getResults(),
                'accountStatusOptions' => $search->getAccountStatusOptions(),
            ],
        );
    }
}
