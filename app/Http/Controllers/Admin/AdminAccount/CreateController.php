<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\AdminAccount;

use App\Http\Controllers\Controller;
use App\Application\Controller\Admin\AdminAccount\Create;
use app\Application\Controller\Shared\Process\ProcessNotFoundException;
use App\Exception\ValidateException;
use App\Security\Auth\AuthContextResolver;
use Illuminate\Http\Request;
use DateTimeImmutable;

class CreateController extends Controller
{
    public function index(Request $request)
    {
        $create = new Create(
            datetime: new DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        return redirect()->route(
            'admin.admin_account.create.input',
            [
                'account_id' => $request->route('account_id'),
                'process_id' => $create->startInputProcess()->getId(),
                ...$request->query(),
            ],
        );
    }

    public function copy(Request $request)
    {
        $create = new Create(
            datetime: new DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        return redirect()->route(
            'admin.admin_account.create.input',
            [
                'account_id' => $request->route('account_id'),
                'process_id' => $create->startInputProcessForCopy()->getId(),
                ...$request->query(),
            ],
        );
    }

    public function input(Request $request)
    {
        $create = new Create(
            datetime: new DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        try {
            return view(
                'admin.AdminAccount.input', 
                [
                    'input' => $create->getInputProcess(),
                    'accountStatusOptions' => $create->getAccountStatusOptions(),
                ]
            );
        } catch (ProcessNotFoundException $ex) {
            logger()->warning('Input process not found', ['exception' => $ex]);
            return $this->redirectToIndex($request);
        }
    }

    public function inputPost(Request $request)
    {
        $create = new Create(
            datetime: new DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        try {
            $create
                ->inputProcessUpdate()
                ->inputProcessValidation()
                ;
            return redirect()->route(
                'admin.admin_account.create.conf',
                [
                    'account_id' => $request->route('account_id'),
                    'process_id' => $request->route('process_id'),
                    ...$request->query(),
                ],
            );
        } catch (ValidateException $ex) {
            $create->inputProcessErrorUpdate($ex);
            return redirect()->route(
                'admin.admin_account.create.input',
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

    public function conf(Request $request)
    {
        $create = new Create(
            datetime: new DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        try {
            return view('admin.AdminAccount.conf', [
                'input' => $create->getInputProcess(),
                'accountStatusOptions' => $create->getAccountStatusOptions(),
            ]);
        } catch (ProcessNotFoundException $ex) {
            logger()->warning('Input process not found', ['exception' => $ex]);
            return $this->redirectToIndex($request);
        }
    }

    public function confPost(Request $request)
    {
        $create = new Create(
            datetime: new DateTimeImmutable(), 
            request: $request, 
            authContext: AuthContextResolver::resolve($request)
        );

        try {
            $create
                ->inputProcessValidation()
                ->saveInputProcess()
                ->endInputProcess()
                ;
            return redirect()->route(
                'admin.admin_account.search.index',
                [
                    'account_id' => $request->route('account_id')
                ]
            )->with('success', '管理者アカウントの作成が完了しました。');
        } catch (ValidateException $ex) {
            $create->inputProcessErrorUpdate($ex);
            return redirect()->back();
        } catch (ProcessNotFoundException $ex) {
            logger()->warning('Input process not found', ['exception' => $ex]);
            return $this->redirectToIndex($request);
        }
    }

    private function redirectToIndex(Request $request): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route(
            'admin.admin_account.create.index',
            [
                'account_id' => $request->route('account_id'),
                ...$request->query(),
            ],
        );
    }
}
