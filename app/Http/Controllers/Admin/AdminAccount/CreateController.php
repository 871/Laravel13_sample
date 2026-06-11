<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\AdminAccount;

use App\Http\Controllers\Controller;
use App\Application\Controller\Admin\AdminAccount\Create as CtlService;
use App\Exception\ValidateException;
use App\Security\Auth\AuthContextResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DateTimeImmutable;

class CreateController extends Controller
{
    public function index(Request $request)
    {
        $service = new CtlService(new DateTimeImmutable(), $request, AuthContextResolver::resolve($request));
        $inputProcess = $service->startInputProcess();

        return redirect()->to(sprintf('%s/create/%s/input', $request->path(), $inputProcess->getId()));
    }

    public function copy(Request $request)
    {
        $service = new CtlService(new DateTimeImmutable(), $request, AuthContextResolver::resolve($request));
        $inputProcess = $service->startInputProcessForCopy();

        return redirect()->to(sprintf('%s/create/%s/input', $request->path(), $inputProcess->getId()));
    }

    public function input(Request $request, $process_id)
    {
        $service = new CtlService(new DateTimeImmutable(), $request, AuthContextResolver::resolve($request));

        $data = [
            'input' => $service->getInputProcess(),
            'accountStatusOptions' => $service->getAccountStatusOptions(),
        ];

        return view('admin.AdminAccount.input', $data);
    }

    public function inputPost(Request $request, string $process_id)
    {
        $service = new CtlService(new DateTimeImmutable(), $request, AuthContextResolver::resolve($request));

        try {
            $service->inputProcessUpdate()->inputProcessValidation();

            return redirect()->to(sprintf('%s/create/%s/conf', $request->path(), $process_id));
        } catch (ValidateException $ex) {
            $service->inputProcessErrorUpdate($ex);

            return redirect()->back();
        }
    }

    public function conf(Request $request, $process_id)
    {
        $service = new CtlService(new DateTimeImmutable(), $request, AuthContextResolver::resolve($request));

        $data = [
            'input' => $service->getInputProcess(),
            'accountStatusOptions' => $service->getAccountStatusOptions(),
        ];

        return view('admin.AdminAccount.conf', $data);
    }

    public function confPost(Request $request, $process_id)
    {
        $service = new CtlService(new DateTimeImmutable(), $request, AuthContextResolver::resolve($request));

        try {
            $service->inputProcessValidation()->saveInputProcess()->endInputProcess();

            return redirect()->route('admin.admin_account.index', ['account_id' => $request->route('account_id')])->with('success', '管理者アカウントの作成が完了しました。');
        } catch (ValidateException $ex) {
            $service->inputProcessErrorUpdate($ex);

            return redirect()->back();
        }
    }
}
