<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\UserAccount;

use App\Http\Controllers\Controller;
use App\Application\Controller\Admin\UserAccount\Edit;
use app\Application\Controller\Shared\Process\ProcessNotFoundException;
use App\Exception\ValidateException;
use App\Security\Auth\AuthContextResolver;
use Illuminate\Http\Request;
use DateTimeImmutable;

class EditController extends Controller
{
    public function index(Request $request, $user_account_id)
    {
        $edit = new Edit(
            datetime: new DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        return redirect()->route(
            'admin.user_account.edit.input',
            [
                ...$request->query(),
                'account_id' => $request->route('account_id'),
                'process_id' => $edit->startInputProcess()->getId(),
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
                'admin.UserAccount.input', 
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
                'admin.user_account.edit.conf',
                [
                    ...$request->query(),
                    'account_id' => $request->route('account_id'),
                    'process_id' => $request->route('process_id'),
                ],
            );
        } catch (ValidateException $ex) {
            $edit->inputProcessErrorUpdate($ex);
            return redirect()->route(
                'admin.user_account.edit.input',
                [
                    ...$request->query(),
                    'account_id' => $request->route('account_id'),
                    'process_id' => $request->route('process_id'),
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
            return view('admin.UserAccount.conf', [
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
                'admin.user_account.search.index',
                [
                    ...$request->query(),
                    'account_id' => $request->route('account_id'),
                ]
            )->with('success', 'ユーザーアカウントの更新が完了しました。');
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
            'admin.user_account.search.index',
            [
                ...$request->query(),
                'account_id' => $request->route('account_id'),
            ],
        )->with('error', '入力プロセスが見つかりませんでした。もう一度最初から操作してください。');
    }
}
