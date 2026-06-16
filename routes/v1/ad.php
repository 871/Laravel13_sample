<?php

use Illuminate\Support\Facades\Route;

// Admin area prefix: /v1/ad
Route::prefix('ad')->as('admin.')->group(function () {
    Route::get('/error/{message_id?}', [App\Http\Controllers\Admin\ErrorController::class, 'index'])->name('error.index');

    Route::get('/login', [App\Http\Controllers\Admin\LoginController::class, 'index'])->name('login.index');
    Route::post('/login', [App\Http\Controllers\Admin\LoginController::class, 'indexPost']);

    // routes under /v1/ad/{account_id}
    Route::prefix('{account_id}')->group(function () {
        // logout routes (should be outside auth middleware per Cake comment)
        Route::get('/logout', [App\Http\Controllers\Admin\LogoutController::class, 'index'])->name('logout.index');
        Route::post('/logout', [App\Http\Controllers\Admin\LogoutController::class, 'indexPost']);

        // TODO　ミドルウェア実装前の表示確認用ルート。ミドルウェア実装後に削除予定。
        // Route::get('/', [App\Http\Controllers\Admin\TopController::class, 'index']);

        // Apply middleware names used in Cake (middleware implementations not required)
        Route::middleware([
            \App\Http\Middleware\Admin\AdminAuthMiddleware::class,
            \App\Http\Middleware\Admin\PageAccessLogMiddleware::class,
            /* 'pageAccessLog', 'adminGrant' */
        ])->group(function () {
            Route::get('/error/{message_id?}', [App\Http\Controllers\Admin\ErrorController::class, 'index'])->name('error.index');
            Route::get('/', [App\Http\Controllers\Admin\TopController::class, 'index'])->name('top.index');
            Route::get('/error_test', [App\Http\Controllers\Admin\TopController::class, 'errorTest'])->name('error.test');

        
            // UserAccount management (/v1/ad/{account_id}/user_account/...)
            Route::prefix('user_account')->as('user_account.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\UserAccount\SearchController::class, 'init'])->name('search.init');
                Route::get('/search', [App\Http\Controllers\Admin\UserAccount\SearchController::class, 'index'])->name('search.index');
                Route::get('/detail/{user_account_id}', [App\Http\Controllers\Admin\UserAccount\DetailController::class, 'index'])->name('detail.index');
                Route::get('/create', [App\Http\Controllers\Admin\UserAccount\CreateController::class, 'index'])->name('create.index');
                Route::get('/create/{process_id}/input', [App\Http\Controllers\Admin\UserAccount\CreateController::class, 'input'])->name('create.input');
                Route::post('/create/{process_id}/input', [App\Http\Controllers\Admin\UserAccount\CreateController::class, 'inputPost'])->name('create.inputPost');
                Route::get('/create/{process_id}/conf', [App\Http\Controllers\Admin\UserAccount\CreateController::class, 'conf'])->name('create.conf');
                Route::post('/create/{process_id}/conf', [App\Http\Controllers\Admin\UserAccount\CreateController::class, 'confPost'])->name('create.confPost');
                Route::get('/create/{user_account_id}/copy', [App\Http\Controllers\Admin\UserAccount\CreateController::class, 'copy'])->name('create.copy');
                Route::get('/edit/{user_account_id}', [App\Http\Controllers\Admin\UserAccount\EditController::class, 'index'])->name('edit.index');
                Route::get('/edit/{process_id}/input', [App\Http\Controllers\Admin\UserAccount\EditController::class, 'input'])->name('edit.input');
                Route::post('/edit/{process_id}/input', [App\Http\Controllers\Admin\UserAccount\EditController::class, 'inputPost'])->name('edit.inputPost');
                Route::get('/edit/{process_id}/conf', [App\Http\Controllers\Admin\UserAccount\EditController::class, 'conf'])->name('edit.conf');
                Route::post('/edit/{process_id}/conf', [App\Http\Controllers\Admin\UserAccount\EditController::class, 'confPost'])->name('edit.confPost');
                Route::get('/delete/{user_account_id}', [App\Http\Controllers\Admin\UserAccount\DeleteController::class, 'index'])->name('delete.index');
                Route::post('/delete/{user_account_id}', [App\Http\Controllers\Admin\UserAccount\DeleteController::class, 'indexPost'])->name('delete.indexPost');
            });
        /*
            // UserGrant management
            Route::prefix('user_grant')->as('user_grant.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\UserGrant\SearchController::class, 'init']);
                Route::get('/search', [App\Http\Controllers\Admin\UserGrant\SearchController::class, 'index']);
                Route::get('/detail/{user_account_id}', [App\Http\Controllers\Admin\UserGrant\DetailController::class, 'index']);
                Route::get('/edit/{user_account_id}', [App\Http\Controllers\Admin\UserGrant\EditController::class, 'index']);
                Route::get('/edit/{process_id}/input', [App\Http\Controllers\Admin\UserGrant\EditController::class, 'input']);
                Route::post('/edit/{process_id}/input', [App\Http\Controllers\Admin\UserGrant\EditController::class, 'inputPost']);
                Route::get('/edit/{process_id}/conf', [App\Http\Controllers\Admin\UserGrant\EditController::class, 'conf']);
                Route::post('/edit/{process_id}/conf', [App\Http\Controllers\Admin\UserGrant\EditController::class, 'confPost']);

                // Role subroutes
                Route::prefix('role')->as('role.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Admin\UserGrant\Role\SearchController::class, 'init']);
                    Route::get('/search', [App\Http\Controllers\Admin\UserGrant\Role\SearchController::class, 'index']);
                    Route::get('/create', [App\Http\Controllers\Admin\UserGrant\Role\CreateController::class, 'index']);
                    Route::get('/create/{process_id}/input', [App\Http\Controllers\Admin\UserGrant\Role\CreateController::class, 'input']);
                    Route::post('/create/{process_id}/input', [App\Http\Controllers\Admin\UserGrant\Role\CreateController::class, 'inputPost']);
                    Route::get('/create/{process_id}/conf', [App\Http\Controllers\Admin\UserGrant\Role\CreateController::class, 'conf']);
                    Route::post('/create/{process_id}/conf', [App\Http\Controllers\Admin\UserGrant\Role\CreateController::class, 'confPost']);
                    Route::get('/detail/{grant_role_id}', [App\Http\Controllers\Admin\UserGrant\Role\DetailController::class, 'index']);
                    Route::get('/edit/{grant_role_id}', [App\Http\Controllers\Admin\UserGrant\Role\EditController::class, 'index']);
                    Route::get('/edit/{process_id}/input', [App\Http\Controllers\Admin\UserGrant\Role\EditController::class, 'input']);
                    Route::post('/edit/{process_id}/input', [App\Http\Controllers\Admin\UserGrant\Role\EditController::class, 'inputPost']);
                    Route::get('/edit/{process_id}/conf', [App\Http\Controllers\Admin\UserGrant\Role\EditController::class, 'conf']);
                    Route::post('/edit/{process_id}/conf', [App\Http\Controllers\Admin\UserGrant\Role\EditController::class, 'confPost']);
                    Route::get('/delete/{grant_role_id}', [App\Http\Controllers\Admin\UserGrant\Role\DeleteController::class, 'index']);
                    Route::post('/delete/{grant_role_id}', [App\Http\Controllers\Admin\UserGrant\Role\DeleteController::class, 'indexPost']);
                });
            });

            // MailManage
            Route::prefix('mail_manage')->as('mail_manage.')->group(function () {
                Route::get('/check_mail_server', [App\Http\Controllers\Admin\MailManage\CheckMailServerController::class, 'index']);
                Route::get('/check_mail_server/sent_smtp', [App\Http\Controllers\Admin\MailManage\CheckMailServerController::class, 'sentSmtp']);
                Route::get('/check_mail_server/received_check_imap', [App\Http\Controllers\Admin\MailManage\CheckMailServerController::class, 'receivedCheckImap']);
                Route::get('/check_mail_server/return_path_imap', [App\Http\Controllers\Admin\MailManage\CheckMailServerController::class, 'returnPathImap']);
                Route::get('/mail_task/send_waiting_mails', [App\Http\Controllers\Admin\MailManage\MailTaskController::class, 'sendWaitingMails']);
                Route::get('/mail_task/check_received_mails', [App\Http\Controllers\Admin\MailManage\MailTaskController::class, 'checkReceivedMails']);
                Route::get('/mail_task/check_bounced_mails', [App\Http\Controllers\Admin\MailManage\MailTaskController::class, 'checkBouncedMails']);
                Route::get('/', [App\Http\Controllers\Admin\MailManage\SearchController::class, 'init']);
                Route::get('/search', [App\Http\Controllers\Admin\MailManage\SearchController::class, 'index']);
                Route::get('/detail/{mail_id}', [App\Http\Controllers\Admin\MailManage\DetailController::class, 'index']);
                Route::get('/create', [App\Http\Controllers\Admin\MailManage\CreateController::class, 'index']);
                Route::get('/create/{process_id}/input', [App\Http\Controllers\Admin\MailManage\CreateController::class, 'input']);
                Route::post('/create/{process_id}/input', [App\Http\Controllers\Admin\MailManage\CreateController::class, 'inputPost']);
                Route::get('/create/{process_id}/conf', [App\Http\Controllers\Admin\MailManage\CreateController::class, 'conf']);
                Route::post('/create/{process_id}/conf', [App\Http\Controllers\Admin\MailManage\CreateController::class, 'confPost']);
            });
        */
            // AdminAccount management
            Route::prefix('admin_account')->as('admin_account.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\AdminAccount\SearchController::class, 'init'])->name('search.init');
                Route::get('/search', [App\Http\Controllers\Admin\AdminAccount\SearchController::class, 'index'])->name('search.index');
                Route::get('/detail/{admin_account_id}', [App\Http\Controllers\Admin\AdminAccount\DetailController::class, 'index'])->name('detail.index');
                Route::get('/create', [App\Http\Controllers\Admin\AdminAccount\CreateController::class, 'index'])->name('create.index');
                Route::get('/create/{process_id}/input', [App\Http\Controllers\Admin\AdminAccount\CreateController::class, 'input'])->name('create.input');
                Route::post('/create/{process_id}/input', [App\Http\Controllers\Admin\AdminAccount\CreateController::class, 'inputPost'])->name('create.inputPost');
                Route::get('/create/{process_id}/conf', [App\Http\Controllers\Admin\AdminAccount\CreateController::class, 'conf'])->name('create.conf');
                Route::post('/create/{process_id}/conf', [App\Http\Controllers\Admin\AdminAccount\CreateController::class, 'confPost'])->name('create.confPost');
                Route::get('/create/{admin_account_id}/copy', [App\Http\Controllers\Admin\AdminAccount\CreateController::class, 'copy'])->name('create.copy');
                Route::get('/edit/{admin_account_id}', [App\Http\Controllers\Admin\AdminAccount\EditController::class, 'index'])->name('edit.index');
                Route::get('/edit/{process_id}/input', [App\Http\Controllers\Admin\AdminAccount\EditController::class, 'input'])->name('edit.input');
                Route::post('/edit/{process_id}/input', [App\Http\Controllers\Admin\AdminAccount\EditController::class, 'inputPost'])->name('edit.inputPost');
                Route::get('/edit/{process_id}/conf', [App\Http\Controllers\Admin\AdminAccount\EditController::class, 'conf'])->name('edit.conf');
                Route::post('/edit/{process_id}/conf', [App\Http\Controllers\Admin\AdminAccount\EditController::class, 'confPost'])->name('edit.confPost');
                Route::get('/delete/{admin_account_id}', [App\Http\Controllers\Admin\AdminAccount\DeleteController::class, 'index'])->name('delete.index');
                Route::post('/delete/{admin_account_id}', [App\Http\Controllers\Admin\AdminAccount\DeleteController::class, 'indexPost'])->name('delete.indexPost');
            });
        /*
            // AdminGrant management
            Route::prefix('admin_grant')->as('admin_grant.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\AdminGrant\SearchController::class, 'init']);
                Route::get('/search', [App\Http\Controllers\Admin\AdminGrant\SearchController::class, 'index']);
                Route::get('/detail/{admin_account_id}', [App\Http\Controllers\Admin\AdminGrant\DetailController::class, 'index']);
                Route::get('/edit/{admin_account_id}', [App\Http\Controllers\Admin\AdminGrant\EditController::class, 'index']);
                Route::get('/edit/{process_id}/input', [App\Http\Controllers\Admin\AdminGrant\EditController::class, 'input']);
                Route::post('/edit/{process_id}/input', [App\Http\Controllers\Admin\AdminGrant\EditController::class, 'inputPost']);
                Route::get('/edit/{process_id}/conf', [App\Http\Controllers\Admin\AdminGrant\EditController::class, 'conf']);
                Route::post('/edit/{process_id}/conf', [App\Http\Controllers\Admin\AdminGrant\EditController::class, 'confPost']);

                    Route::prefix('role')->as('role.')->group(function () {
                    Route::get('/', [App\Http\Controllers\Admin\AdminGrant\Role\SearchController::class, 'init']);
                    Route::get('/search', [App\Http\Controllers\Admin\AdminGrant\Role\SearchController::class, 'index']);
                    Route::get('/create', [App\Http\Controllers\Admin\AdminGrant\Role\CreateController::class, 'index']);
                    Route::get('/create/{process_id}/input', [App\Http\Controllers\Admin\AdminGrant\Role\CreateController::class, 'input']);
                    Route::post('/create/{process_id}/input', [App\Http\Controllers\Admin\AdminGrant\Role\CreateController::class, 'inputPost']);
                    Route::get('/create/{process_id}/conf', [App\Http\Controllers\Admin\AdminGrant\Role\CreateController::class, 'conf']);
                    Route::post('/create/{process_id}/conf', [App\Http\Controllers\Admin\AdminGrant\Role\CreateController::class, 'confPost']);
                    Route::get('/detail/{grant_role_id}', [App\Http\Controllers\Admin\AdminGrant\Role\DetailController::class, 'index']);
                    Route::get('/edit/{grant_role_id}', [App\Http\Controllers\Admin\AdminGrant\Role\EditController::class, 'index']);
                    Route::get('/edit/{process_id}/input', [App\Http\Controllers\Admin\AdminGrant\Role\EditController::class, 'input']);
                    Route::post('/edit/{process_id}/input', [App\Http\Controllers\Admin\AdminGrant\Role\EditController::class, 'inputPost']);
                    Route::get('/edit/{process_id}/conf', [App\Http\Controllers\Admin\AdminGrant\Role\EditController::class, 'conf']);
                    Route::post('/edit/{process_id}/conf', [App\Http\Controllers\Admin\AdminGrant\Role\EditController::class, 'confPost']);
                    Route::get('/delete/{grant_role_id}', [App\Http\Controllers\Admin\AdminGrant\Role\DeleteController::class, 'index']);
                    Route::post('/delete/{grant_role_id}', [App\Http\Controllers\Admin\AdminGrant\Role\DeleteController::class, 'indexPost']);
                });

                // Log prefixes
                Route::prefix('log')->as('log.')->group(function () {
                    Route::prefix('login_log')->as('login_log.')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\Log\LoginLog\SearchController::class, 'init']);
                        Route::get('/search', [App\Http\Controllers\Admin\Log\LoginLog\SearchController::class, 'index']);
                        Route::get('/detail/{login_log_id}', [App\Http\Controllers\Admin\Log\LoginLog\DetailController::class, 'index']);
                    });

                    Route::prefix('page_access_log')->group(function () {
                        Route::get('/', [App\Http\Controllers\Admin\Log\PageAccessLog\SearchController::class, 'init']);
                        Route::get('/search', [App\Http\Controllers\Admin\Log\PageAccessLog\SearchController::class, 'index']);
                    });
                });
            });
    */
        });
    });
});