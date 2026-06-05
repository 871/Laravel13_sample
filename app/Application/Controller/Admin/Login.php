<?php

declare(strict_types=1);

namespace App\Application\Controller\Admin;

use App\Application\Controller\Shared\ApplicationInterface;
use App\Application\Controller\Shared\ApplicationTrait;
use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as AccountEntity;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Log\LoginLogs\Entity\LoginLog as LoginLogEntity;
use App\Domain\Log\LoginLogs\ValueObject as LoginLogVo;
use App\Domain\Shared\ValueObject as SVo;
use App\Exception\AuthException;
use App\Infrastructure\Persistence\Eloquent\Admin\AdminAccountsRepository;
use App\Infrastructure\Persistence\Eloquent\Admin\AdminAccountsRepository\Mapper as AdminAccountMapper;
use App\Infrastructure\Persistence\Eloquent\Log\LoginLogs\LoginLogsRepository;
use App\Lib\UUID\UUID;
use App\Security\Auth\AuthContext\Fields\Type;
use App\Security\Auth\AuthSession;
use App\Security\Input\StrictCast;
use Illuminate\Support\Facades\Hash;


final class Login implements ApplicationInterface
{
    use ApplicationTrait;
    /**
     * @var \App\Domain\Admin\AdminAccounts\Entity\AdminAccount
     */
    private AccountEntity $accountEntity;

    /**
     * @var string
     */
    private string $login_id;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var string
     */
    private string $account_id;

    /**
     * @param string $login_id
     * @param string $password
     * @return self
     */
    public function login(
        string $login_id,
        string $password,
    ): self {
        $this->login_id = $login_id;
        $this->password = $password;

        try {
            return $this
                ->checkLoginFailureCount() // ログイン失敗回数超過チェック
                ->loadAccountEntity() // 管理者情報取得
                ->verifyPassword() // PW照合
                ->checkPasswordExpiresAt() // 有効期限
                ->checkAccountStatus() // ステータス判定
                ->createLoginSession(); // ログインセッション作成
        } catch (AuthException $e) {
            $this->recordLoginFailure($e); // ログイン失敗ログ出力

            throw $e;
        }
    }

    /**
     * @return self
     */
    private function checkLoginFailureCount(): self
    {
        /**  TODO 未実装
        if (!(new LoginLogsRepository())->checkFailureLoginLimit(LoginLogVo\LoginId::fromString($this->login_id))) {
            throw new AuthException(
                __('ログイン失敗回数が上限に達したため、アカウントがロックされました。しばらくしてから再度お試しください。'),
                AuthException::LOGIN_FAIL_COUNT_OVER,
            );
        }
        */

        return $this;
    }

    /**
     * @return self
     */
    private function loadAccountEntity(): self
    {
        $this->accountEntity = (new AdminAccountsRepository($this->datetime))
            ->findByEmail(Vo\Email::fromString($this->login_id))
            ?? throw new AuthException(
                __('ログインIDまたはパスワードが違います。'),
                AuthException::LOGIN_ID_NOT_FOUND,
            );

        return $this;
    }

    /**
     * @return self
     */
    private function verifyPassword(): self
    {
        $check = Hash::check($this->password, $this->accountEntity->password()->toString());
        if (!$check) {
            throw new AuthException(
                __('ログインIDまたはパスワードが違います。'),
                AuthException::INVALID_PASSWORD,
            );
        }

        return $this;
    }

    /**
     * @return self
     */
    private function checkPasswordExpiresAt(): self
    {
        $expiresTimestamp = $this->accountEntity
            ->passwordExpiresAt()
            ->toDateTimeOrNull()
            ?->getTimestamp() ?? 0;

        $nowTimestamp = $this->datetime->getTimestamp();
        if ($expiresTimestamp < $nowTimestamp) {
            throw new AuthException(
                __('パスワードの有効期限が切れています。'),
                AuthException::PASSWORD_EXPIRED,
            );
        }

        return $this;
    }

    /**
     * @return self
     */
    private function checkAccountStatus(): self
    {
        return match ($this->accountEntity->accountStatusMasterCode()->toString()) {
            Vo\AccountStatusMasterCode::ACTIVE => $this,
            Vo\AccountStatusMasterCode::PENDING => $this,
            Vo\AccountStatusMasterCode::SUSPENDED => throw new AuthException(
                __('アカウントが無効です。'),
                AuthException::ACCOUNT_SUSPENDED,
            ),
            Vo\AccountStatusMasterCode::LOCKED => throw new AuthException(
                __('アカウントが無効です。'),
                AuthException::ACCOUNT_LOCKED,
            ),
            Vo\AccountStatusMasterCode::DELETED => throw new AuthException(
                __('アカウントが無効です。'),
                AuthException::ACCOUNT_DELETED,
            ),
            default => throw new AuthException(
                __('アカウントが無効です。'),
                AuthException::AUTHENTICATION_FAILED,
            ),
        };
    }

    /**
     * @return self
     */
    private function createLoginSession(): self
    {
        $this->account_id = $this->accountEntity->id()->toString();
        
        $authSession = new AuthSession(
            request: $this->request,
            type: Type::TYPE_ADMIN,
            account_id: $this->account_id,
        );
        $authSession->write([
            'account_id' => $this->accountEntity->id()->toString(),
            'account_email' => $this->accountEntity->email()->toString(),
            'account_name' => $this->accountEntity->name()->toString(),
            'account_status_master_id' => $this->accountEntity->accountStatusMasterId()->toString(),
            'account_status_master_code' => $this->accountEntity->accountStatusMasterCode()->toString(),
            'account_status_master_name' => $this->accountEntity->accountStatusMasterName()->toString(),
            'is_email_verified' => $this->accountEntity->isEmailVerified()->toString(),
            'password_changed_at' => $this->accountEntity->passwordChangedAt()->format('Y-m-d\TH:i:s'),
            'password_expires_at' => $this->accountEntity->passwordExpiresAt()->format('Y-m-d\TH:i:s'),
            'created' => $this->accountEntity->createdAt()->format('Y-m-d\TH:i:s'),
            'created_by' => $this->accountEntity->createdBy()->toString(),
            'created_ip' => $this->accountEntity->createdIp()->toString(),
            'modified' => $this->accountEntity->modifiedAt()->format('Y-m-d\TH:i:s'),
            'modified_by' => $this->accountEntity->modifiedBy()->toString(),
            'modified_ip' => $this->accountEntity->modifiedIp()->toString(),
            'logined' => $this->datetime->format('Y-m-d\TH:i:s'),
        ]);

        return $this;
    }

    /**
     * @return self
     */
    public function recordLoginSuccess(): self
    {
        /** TODO 未実装
        (new LoginLogsRepository())->create(new LoginLogEntity(
            id: new LoginLogVo\Id(UUID::uuid7()),
            login_id: new LoginLogVo\LoginId($this->login_id),
            login_actor_type: new LoginLogVo\LoginActorType(LoginLogVo\LoginActorType::ADMIN),
            account_id: new LoginLogVo\AccountId(
                isset($this->accountEntity) ? $this->accountEntity->id()->toString() : null,
            ), // ログインIDをaccount_idとして記録
            impersonator_account_id: new LoginLogVo\ImpersonatorAccountId(null),
            login_result: new LoginLogVo\LoginResult(LoginLogVo\LoginResult::SUCCESS),
            ip_address: LoginLogVo\IpAddress::fromString($this->request->clientIp()),
            user_agent: LoginLogVo\UserAgent::fromString($this->request->getHeaderLine('User-Agent')),
            failure_reason_code: LoginLogVo\FailureReasonCode::fromString(null),
            logged_in_at: new LoginLogVo\LoggedInAt($this->datetime->format('Y-m-d\TH:i:s')),
            created: new SVo\Created($this->datetime->format('Y-m-d\TH:i:s')),
        ));
        */

        return $this;
    }

    /**
     * @return string
     */
    public function getRedirect(): string
    {
        // ログイン前のURLが特定のパターンにマッチする場合は、そのURLにリダイレクト。それ以外は管理画面トップへリダイレクト。
        // 例）/v1/ad/{account_id}/... → /v1/ad/{ログインしたアカウントのaccount_id}/...
        // オープンリダイレクト脆弱性対策もここで行う（リダイレクト先が特定のパターンにマッチしない場合は、リダイレクト先を管理画面トップに固定する）
        $redirect = $this->request->session()->get('url.intended');
        if (preg_match('/^\/v1\/ad\/\d+\/.*$/', $redirect)) {
            /** @var string */
            return preg_replace('/^(\/v1\/ad)\/\d+\/(.*)$/', '$1/' . $this->account_id . '/$2', $redirect);
        }

        return url('/v1/ad/' . StrictCast::toString($this->request->route('account_id')));
    }

    /**
     * @param \App\Exception\AuthException $e
     */
    public function recordLoginFailure(AuthException $e): self
    {
        if ($e->getFailureReasonCode() === AuthException::LOGIN_FAIL_COUNT_OVER) {
            return $this; // ログイン失敗回数超過の場合は、ログイン失敗ログの記録は行わない（すでにログイン失敗回数超過の状態であるため）
        }

        /* TODO 未実装
        (new LoginLogsRepository())->create(new LoginLogEntity(
            id: new LoginLogVo\Id(UUID::uuid7()),
            login_id: new LoginLogVo\LoginId($this->login_id),
            login_actor_type: new LoginLogVo\LoginActorType(LoginLogVo\LoginActorType::ADMIN),
            account_id: new LoginLogVo\AccountId(
                isset($this->accountEntity) ? $this->accountEntity->id()->toString() : null,
            ),
            impersonator_account_id: new LoginLogVo\ImpersonatorAccountId(null),
            login_result: new LoginLogVo\LoginResult(LoginLogVo\LoginResult::FAILURE),
            ip_address: LoginLogVo\IpAddress::fromString($this->request->clientIp()),
            user_agent: LoginLogVo\UserAgent::fromString($this->request->getHeaderLine('User-Agent')),
            failure_reason_code: LoginLogVo\FailureReasonCode::fromString($e->getFailureReasonCode()),
            logged_in_at: new LoginLogVo\LoggedInAt($this->datetime->format('Y-m-d\TH:i:s')),
            created: new SVo\Created($this->datetime->format('Y-m-d\TH:i:s')),
        ));
        */
        return $this;
    }
}
