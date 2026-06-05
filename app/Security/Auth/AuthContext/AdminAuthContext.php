<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext;

use App\Security\Auth\AuthContext;
use App\Security\Auth\AuthSession;
use App\Security\Input\StrictCast;
use Illuminate\Http\Request;

final class AdminAuthContext implements AuthContext
{
    /**
     * @var array<string, mixed>
     */
    private array $auth;

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(
        private readonly Request $request,
    ) {
        $this->auth = (new AuthSession(
            request: $this->request,
            type: Fields\Type::TYPE_ADMIN,
            account_id: $this->request->route('account_id')
        ))->read();
    }

    /**
     * @return \App\Security\Auth\AuthContext\Fields\Type
     */
    public function getType(): Fields\Type
    {
        return new Fields\Type(Fields\Type::TYPE_ADMIN);
    }

    /**
     * @return \App\Security\Auth\AuthContext\Fields\AccountId
     */
    public function getAccountId(): Fields\AccountId
    {
        return new Fields\AccountId\AdminAccountId($this->auth['account_id']);
    }

    /**
     * 認証アカウントメールアドレス
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountEmail
     */
    public function getAccountEmail(): Fields\AccountEmail
    {
        return new Fields\AccountEmail($this->auth['account_email']);
    }

    /**
     * 認証アカウント表示名
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountName
     */
    public function getAccountName(): Fields\AccountName
    {
        return new Fields\AccountName($this->auth['account_name']);
    }

    /**
     * 認証アカウントステータスマスターID
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountStatusMasterId
     */
    public function getAccountStatusMasterId(): Fields\AccountStatusMasterId
    {
        return new Fields\AccountStatusMasterId($this->auth['account_status_master_id']);
    }

    /**
     * 認証アカウントステータスマスターネーム
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountStatusMasterName
     */
    public function getAccountStatusMasterName(): Fields\AccountStatusMasterName
    {
        return new Fields\AccountStatusMasterName($this->auth['account_status_master_name']);
    }

    /**
     * 認証アカウントステータスマスターコード
     *
     * @return \App\Security\Auth\AuthContext\Fields\AccountStatusMasterCode
     */
    public function getAccountStatusMasterCode(): Fields\AccountStatusMasterCode
    {
        return new Fields\AccountStatusMasterCode($this->auth['account_status_master_code']);
    }

    /**
     * 認証アカウントメール確認済フラグ
     *
     * @return \App\Security\Auth\AuthContext\Fields\IsEmailVerified
     */
    public function getIsEmailVerified(): Fields\IsEmailVerified
    {
        return new Fields\IsEmailVerified($this->auth['is_email_verified']);
    }

    /**
     * 認証アカウントパスワード最終変更日時
     *
     * @return \App\Security\Auth\AuthContext\Fields\PasswordChangedAt
     */
    public function getPasswordChangedAt(): Fields\PasswordChangedAt
    {
        return new Fields\PasswordChangedAt($this->auth['password_changed_at']);
    }

    /**
     * 認証アカウントパスワード有効期限
     *
     * @return \App\Security\Auth\AuthContext\Fields\PasswordExpiresAt
     */
    public function getPasswordExpiresAt(): Fields\PasswordExpiresAt
    {
        return new Fields\PasswordExpiresAt($this->auth['password_expires_at']);
    }

    /**
     * 認証アカウント作成日時
     *
     * @return \App\Security\Auth\AuthContext\Fields\Created
     */
    public function getCreated(): Fields\Created
    {
        return new Fields\Created($this->auth['created']);
    }

    /**
     * 認証アカウント更新日時
     *
     * @return \App\Security\Auth\AuthContext\Fields\Modified
     */
    public function getModified(): Fields\Modified
    {
        return new Fields\Modified($this->auth['modified']);
    }

    /**
     * ログイン日時
     *
     * @return \App\Security\Auth\AuthContext\Fields\Logined
     */
    public function getLogined(): Fields\Logined
    {
        return new Fields\Logined($this->auth['logined']);
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
     * @return AuthContext|null
     */
    public function impersonatorAccount(): ?AuthContext
    {
        return null;
    }
}
