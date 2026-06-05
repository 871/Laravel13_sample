<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext;

use App\Security\Auth\AuthContext;
use Illuminate\Http\Request;

final class AnonymousAuthContext implements AuthContext
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        // 処理なし
        unset($request); // 静的解析対策
    }

    /**
     * @return \App\Security\Auth\AuthContext\Fields\Type
     */
    public function getType(): Fields\Type
    {
        return new Fields\Type(Fields\Type::TYPE_ANONYMOUS);
    }

    /**
     * @return \App\Security\Auth\AuthContext\Fields\AccountId
     */
    public function getAccountId(): Fields\AccountId
    {
        return new Fields\AccountId\AnonymousAccountId('0');
    }

    /**
     * 認証アカウントメールアドレス
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountEmail
     */
    public function getAccountEmail(): Fields\AccountEmail
    {
        return new Fields\AccountEmail(null);
    }

    /**
     * 認証アカウント表示名
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountName
     */
    public function getAccountName(): Fields\AccountName
    {
        return new Fields\AccountName('Anonymous');
    }

    /**
     * 認証アカウントステータスマスターID
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountStatusMasterId
     */
    public function getAccountStatusMasterId(): Fields\AccountStatusMasterId
    {
        return new Fields\AccountStatusMasterId(null);
    }

    /**
     * 認証アカウントステータスマスターネーム
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountStatusMasterName
     */
    public function getAccountStatusMasterName(): Fields\AccountStatusMasterName
    {
        return new Fields\AccountStatusMasterName(null);
    }

    /**
     * 認証アカウントステータスマスターコード
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountStatusMasterCode
     */
    public function getAccountStatusMasterCode(): Fields\AccountStatusMasterCode
    {
        return new Fields\AccountStatusMasterCode(null);
    }

    /**
     * 認証アカウントメール確認済フラグ
     *
     * @return \App\Security\Auth\AuthContext\Fields\IsEmailVerified
     */
    public function getIsEmailVerified(): Fields\IsEmailVerified
    {
        return new Fields\IsEmailVerified(false);
    }

    /**
     * 認証アカウントパスワード最終変更日時
     *
     * @return \App\Security\Auth\AuthContext\Fields\PasswordChangedAt
     */
    public function getPasswordChangedAt(): Fields\PasswordChangedAt
    {
        return new Fields\PasswordChangedAt(null);
    }

    /**
     * 認証アカウントパスワード有効期限
     *
     * @return \App\Security\Auth\AuthContext\Fields\PasswordExpiresAt
     */
    public function getPasswordExpiresAt(): Fields\PasswordExpiresAt
    {
        return new Fields\PasswordExpiresAt(null);
    }

    /**
     * 認証アカウント作成日時
     *
     * @return \App\Security\Auth\AuthContext\Fields\Created
     */
    public function getCreated(): Fields\Created
    {
        return new Fields\Created(null);
    }

    /**
     * 認証アカウント更新日時
     *
     * @return \App\Security\Auth\AuthContext\Fields\Modified
     */
    public function getModified(): Fields\Modified
    {
        return new Fields\Modified(null);
    }

    /**
     * ログイン日時
     *
     * @return \App\Security\Auth\AuthContext\Fields\Logined
     */
    public function getLogined(): Fields\Logined
    {
        return new Fields\Logined(null);
    }

    /**
     * 代理ログインフラグ
     *
     * @return bool
     */
    public function isImpersonatorLogin(): bool
    {
        return false;
    }

    /**
     * 代理ログイン元アカウント
     *
     * @return self|null
     */
    public function impersonatorAccount(): ?self
    {
        return null;
    }
}
