<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\AdminAccount;

use App\Http\Controllers\Controller;
use App\Application\Controller\Admin\AdminAccount\Search as CtlService;
use App\Security\Auth\AuthContextResolver;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function init(Request $request)
    {
        $service = new CtlService(new \DateTimeImmutable(), $request, AuthContextResolver::resolve($request));

        $params = $service->getInitParams();

        // Redirect to index with query params
        $query = http_build_query($params);
        $target = $request->path() . ($query !== '' ? ('?'.$query) : '');

        return redirect($target);
    }

    public function index(Request $request)
    {
        $service = new CtlService(new \DateTimeImmutable(), $request, AuthContextResolver::resolve($request));

        $rows = $service->getSearchQuery();
        $paginateSettings = $service->getPaginateSettings();

        return view('admin.AdminAccount.search', [
            'rows' => $rows,
            'paginateSettings' => $paginateSettings,
            'accountStatusOptions' => $service->getAccountStatusOptions(),
        ]);
    }
}
