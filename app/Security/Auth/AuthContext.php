<?php
declare(strict_types=1);

namespace App\Security\Auth;

use App\Security\Auth\AuthContext\Fields;
use Illuminate\Http\Request;

interface AuthContext
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request);

    /**
     * 認証コンテキストのタイプ
     *
     * @return \App\Security\Auth\AuthContext\Fields\Type
     */
    public function getType(): Fields\Type;

    /**
     * 認証アカウントID
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountId
     */
    public function getAccountId(): Fields\AccountId;

    /**
     * 認証アカウントメールアドレス
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountEmail
     */
    public function getAccountEmail(): Fields\AccountEmail;

    /**
     * 認証アカウント表示名
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountName
     */
    public function getAccountName(): Fields\AccountName;

    /**
     * 認証アカウントステータスマスターID
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountStatusMasterId
     */
    public function getAccountStatusMasterId(): Fields\AccountStatusMasterId;

    /**
     * 認証アカウントステータスマスターネーム
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountStatusMasterName
     */
    public function getAccountStatusMasterName(): Fields\AccountStatusMasterName;

    /**
     * 認証アカウントステータスマスターコード
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountStatusMasterCode
     */
    public function getAccountStatusMasterCode(): Fields\AccountStatusMasterCode;

    /**
     * 認証アカウントメール確認済フラグ
     *
     * @return \App\Security\Auth\AuthContext\Fields\IsEmailVerified
     */
    public function getIsEmailVerified(): Fields\IsEmailVerified;

    /**
     * 認証アカウントパスワード最終変更日時
     *
     * @return \App\Security\Auth\AuthContext\Fields\PasswordChangedAt
     */
    public function getPasswordChangedAt(): Fields\PasswordChangedAt;

    /**
     * 認証アカウントパスワード有効期限
     *
     * @return \App\Security\Auth\AuthContext\Fields\PasswordExpiresAt
     */
    public function getPasswordExpiresAt(): Fields\PasswordExpiresAt;

    /**
     * 認証アカウント作成日時
     *
     * @return \App\Security\Auth\AuthContext\Fields\Created
     */
    public function getCreated(): Fields\Created;

    /**
     * 認証アカウント更新日時
     *
     * @return \App\Security\Auth\AuthContext\Fields\Modified
     */
    public function getModified(): Fields\Modified;

    /**
     * ログイン日時
     *
     * @return \App\Security\Auth\AuthContext\Fields\Logined
     */
    public function getLogined(): Fields\Logined;

    /**
     * 代理ログインフラグ
     *
     * @return bool
     */
    public function isImpersonatorLogin(): bool;

    /**
     * 代理ログイン元アカウント
     *
     * @return self|null
     */
    public function impersonatorAccount(): ?self;
}
