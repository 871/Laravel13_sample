<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\AdminAccount;

use App\Http\Controllers\Controller;
use App\Application\Controller\Admin\AdminAccount\Edit;
use app\Application\Controller\Shared\Process\ProcessNotFoundException;
use App\Exception\ValidateException;
use App\Security\Auth\AuthContextResolver;
use Illuminate\Http\Request;
use DateTimeImmutable;

class EditController extends Controller
{
    public function index(Request $request, $admin_account_id)
    {
        $edit = new Edit(
            datetime: new DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        return redirect()->route(
            'admin.admin_account.edit.input',
            [
                'account_id' => $request->route('account_id'),
                'process_id' => $edit->startInputProcess()->getId(),
                ...$request->query(),
            ],
        );
   }

    public function input(Request $request, $process_id)
    {
        $edit = new Edit(
            datetime: new DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        try {
            return view(
                'admin.AdminAccount.input', 
                [
                    'input' => $edit->getInputProcess(),
                    'accountStatusOptions' => $edit->getAccountStatusOptions(),
                ]
            );
        } catch (ProcessNotFoundException $ex) {
            logger()->warning('Input process not found', ['exception' => $ex]);
            return $this->redirectToIndex($request);
        }
    }

    public function inputPost(Request $request, $process_id)
    {
        $edit = new Edit(
            datetime: new DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        try {
            $edit
                ->inputProcessUpdate()
                ->inputProcessValidation()
                ;
            return redirect()->route(
                'admin.admin_account.edit.conf',
                [
                    'account_id' => $request->route('account_id'),
                    'process_id' => $request->route('process_id'),
                    ...$request->query(),
                ],
            );
        } catch (ValidateException $ex) {
            $edit->inputProcessErrorUpdate($ex);
            return redirect()->route(
                'admin.admin_account.edit.input',
                [
                    'account_id' => $request->route('account_id'),
                    'process_id' => $request->route('process_id'),
                    ...$request->query(),
                ],
            );
        } catch (ProcessNotFoundException $ex) {
            logger()->warning('Input process not found', ['exception' => $ex]);
            return $this->redirectToIndex($request);
        }
    }

    public function conf(Request $request, $process_id)
    {
        $edit = new Edit(
            datetime: new DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        try {
            return view('admin.AdminAccount.conf', [
                'input' => $edit->getInputProcess(),
                'accountStatusOptions' => $edit->getAccountStatusOptions(),
            ]);
        } catch (ProcessNotFoundException $ex) {
            logger()->warning('Input process not found', ['exception' => $ex]);
            return $this->redirectToIndex($request);
        }
    }

    public function confPost(Request $request, $process_id)
    {
        $edit = new Edit(
            datetime: new DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        try {
            $edit
                ->inputProcessValidation()
                ->saveInputProcess()
                ->endInputProcess()
                ;
            return redirect()->route(
                'admin.admin_account.search.index',
                [
                    'account_id' => $request->route('account_id'),
                    ...$request->query(),
                ]
            )->with('success', '管理者アカウントの更新が完了しました。');
        } catch (ValidateException $ex) {
            $edit->inputProcessErrorUpdate($ex);
            return redirect()->back();
        } catch (ProcessNotFoundException $ex) {
            logger()->warning('Input process not found', ['exception' => $ex]);
            return $this->redirectToIndex($request);
        }
    }

    private function redirectToIndex(Request $request): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route(
            'admin.admin_account.search.index',
            [
                'account_id' => $request->route('account_id'),
                ...$request->query(),
            ],
        )->with('error', '入力プロセスが見つかりませんでした。もう一度最初から操作してください。');
    }
}
