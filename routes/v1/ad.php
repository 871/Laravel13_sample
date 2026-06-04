<?php

use Illuminate\Support\Facades\Route;

// Admin area prefix: /v1/ad
Route::prefix('ad')->group(function () {
    // public error and login
    Route::get('/error', [App\Http\Controllers\Admin\ErrorController::class, 'index']);
    Route::get('/error/{message_id}', [App\Http\Controllers\Admin\ErrorController::class, 'index']);

    Route::get('/login', [App\Http\Controllers\Admin\LoginController::class, 'index']);
    Route::post('/login', [App\Http\Controllers\Admin\LoginController::class, 'indexPost']);

    // routes under /v1/ad/{account_id}
    Route::prefix('{account_id}')->group(function () {
        // logout routes (should be outside auth middleware per Cake comment)
        Route::get('/logout', [App\Http\Controllers\Admin\LogoutController::class, 'index']);
        Route::post('/logout', [App\Http\Controllers\Admin\LogoutController::class, 'indexPost']);

        // Apply middleware names used in Cake (middleware implementations not required)
        Route::middleware(['adminAuth', 'pageAccessLog', 'adminGrant'])->group(function () {
            Route::get('/error', [App\Http\Controllers\Admin\ErrorController::class, 'index']);
            Route::get('/error/{message_id}', [App\Http\Controllers\Admin\ErrorController::class, 'index']);
            Route::get('/', [App\Http\Controllers\Admin\TopController::class, 'index']);
            Route::get('/error_test', [App\Http\Controllers\Admin\TopController::class, 'errorTest']);

            // UserAccount management (/v1/ad/{account_id}/user_account/...)
            Route::prefix('user_account')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\UserAccount\SearchController::class, 'init']);
                Route::get('/search', [App\Http\Controllers\Admin\UserAccount\SearchController::class, 'index']);
                Route::get('/detail/{user_account_id}', [App\Http\Controllers\Admin\UserAccount\DetailController::class, 'index']);
                Route::get('/create', [App\Http\Controllers\Admin\UserAccount\CreateController::class, 'index']);
                Route::get('/create/{process_id}/input', [App\Http\Controllers\Admin\UserAccount\CreateController::class, 'input']);
                Route::post('/create/{process_id}/input', [App\Http\Controllers\Admin\UserAccount\CreateController::class, 'inputPost']);
                Route::get('/create/{process_id}/conf', [App\Http\Controllers\Admin\UserAccount\CreateController::class, 'conf']);
                Route::post('/create/{process_id}/conf', [App\Http\Controllers\Admin\UserAccount\CreateController::class, 'confPost']);
                Route::get('/create/{user_account_id}/copy', [App\Http\Controllers\Admin\UserAccount\CreateController::class, 'copy']);
                Route::get('/edit/{user_account_id}', [App\Http\Controllers\Admin\UserAccount\EditController::class, 'index']);
                Route::get('/edit/{process_id}/input', [App\Http\Controllers\Admin\UserAccount\EditController::class, 'input']);
                Route::post('/edit/{process_id}/input', [App\Http\Controllers\Admin\UserAccount\EditController::class, 'inputPost']);
                Route::get('/edit/{process_id}/conf', [App\Http\Controllers\Admin\UserAccount\EditController::class, 'conf']);
                Route::post('/edit/{process_id}/conf', [App\Http\Controllers\Admin\UserAccount\EditController::class, 'confPost']);
                Route::get('/delete/{user_account_id}', [App\Http\Controllers\Admin\UserAccount\DeleteController::class, 'index']);
                Route::post('/delete/{user_account_id}', [App\Http\Controllers\Admin\UserAccount\DeleteController::class, 'indexPost']);
            });

            // UserGrant management
            Route::prefix('user_grant')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\UserGrant\SearchController::class, 'init']);
                Route::get('/search', [App\Http\Controllers\Admin\UserGrant\SearchController::class, 'index']);
                Route::get('/detail/{user_account_id}', [App\Http\Controllers\Admin\UserGrant\DetailController::class, 'index']);
                Route::get('/edit/{user_account_id}', [App\Http\Controllers\Admin\UserGrant\EditController::class, 'index']);
                Route::get('/edit/{process_id}/input', [App\Http\Controllers\Admin\UserGrant\EditController::class, 'input']);
                Route::post('/edit/{process_id}/input', [App\Http\Controllers\Admin\UserGrant\EditController::class, 'inputPost']);
                Route::get('/edit/{process_id}/conf', [App\Http\Controllers\Admin\UserGrant\EditController::class, 'conf']);
                Route::post('/edit/{process_id}/conf', [App\Http\Controllers\Admin\UserGrant\EditController::class, 'confPost']);

                // Role subroutes
                Route::prefix('role')->group(function () {
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
            Route::prefix('mail_manage')->group(function () {
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

            // AdminAccount management
            Route::prefix('admin_account')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\AdminAccount\SearchController::class, 'init']);
                Route::get('/search', [App\Http\Controllers\Admin\AdminAccount\SearchController::class, 'index']);
                Route::get('/detail/{admin_account_id}', [App\Http\Controllers\Admin\AdminAccount\DetailController::class, 'index']);
                Route::get('/create', [App\Http\Controllers\Admin\AdminAccount\CreateController::class, 'index']);
                Route::get('/create/{process_id}/input', [App\Http\Controllers\Admin\AdminAccount\CreateController::class, 'input']);
                Route::post('/create/{process_id}/input', [App\Http\Controllers\Admin\AdminAccount\CreateController::class, 'inputPost']);
                Route::get('/create/{process_id}/conf', [App\Http\Controllers\Admin\AdminAccount\CreateController::class, 'conf']);
                Route::post('/create/{process_id}/conf', [App\Http\Controllers\Admin\AdminAccount\CreateController::class, 'confPost']);
                Route::get('/create/{admin_account_id}/copy', [App\Http\Controllers\Admin\AdminAccount\CreateController::class, 'copy']);
                Route::get('/edit/{admin_account_id}', [App\Http\Controllers\Admin\AdminAccount\EditController::class, 'index']);
                Route::get('/edit/{process_id}/input', [App\Http\Controllers\Admin\AdminAccount\EditController::class, 'input']);
                Route::post('/edit/{process_id}/input', [App\Http\Controllers\Admin\AdminAccount\EditController::class, 'inputPost']);
                Route::get('/edit/{process_id}/conf', [App\Http\Controllers\Admin\AdminAccount\EditController::class, 'conf']);
                Route::post('/edit/{process_id}/conf', [App\Http\Controllers\Admin\AdminAccount\EditController::class, 'confPost']);
                Route::get('/delete/{admin_account_id}', [App\Http\Controllers\Admin\AdminAccount\DeleteController::class, 'index']);
                Route::post('/delete/{admin_account_id}', [App\Http\Controllers\Admin\AdminAccount\DeleteController::class, 'indexPost']);
            });

            // AdminGrant management
            Route::prefix('admin_grant')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\AdminGrant\SearchController::class, 'init']);
                Route::get('/search', [App\Http\Controllers\Admin\AdminGrant\SearchController::class, 'index']);
                Route::get('/detail/{admin_account_id}', [App\Http\Controllers\Admin\AdminGrant\DetailController::class, 'index']);
                Route::get('/edit/{admin_account_id}', [App\Http\Controllers\Admin\AdminGrant\EditController::class, 'index']);
                Route::get('/edit/{process_id}/input', [App\Http\Controllers\Admin\AdminGrant\EditController::class, 'input']);
                Route::post('/edit/{process_id}/input', [App\Http\Controllers\Admin\AdminGrant\EditController::class, 'inputPost']);
                Route::get('/edit/{process_id}/conf', [App\Http\Controllers\Admin\AdminGrant\EditController::class, 'conf']);
                Route::post('/edit/{process_id}/conf', [App\Http\Controllers\Admin\AdminGrant\EditController::class, 'confPost']);

                    Route::prefix('role')->group(function () {
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
                Route::prefix('log')->group(function () {
                    Route::prefix('login_log')->group(function () {
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
        });
    });
});