<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\AdminAccount;

use App\Http\Controllers\Controller;
use App\Application\Controller\Admin\AdminAccount\Detail as CtlService;
use App\Security\Auth\AuthContextResolver;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index(Request $request, $admin_account_id)
    {
        $service = new CtlService(new \DateTimeImmutable(), $request, AuthContextResolver::resolve($request));

        $data = [
            'entity' => $service->getDomainEntity(),
            'histories' => $service->getHistories(),
        ];

        return view('admin.AdminAccount.detail', $data);
    }
}
