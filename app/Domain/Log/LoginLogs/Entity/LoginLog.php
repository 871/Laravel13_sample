<?php
declare(strict_types=1);

namespace App\Domain\Log\LoginLogs\Entity;

use App\Domain\Log\LoginLogs\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;

final class LoginLog
{
    /**
     * @param \App\Domain\Log\LoginLogs\ValueObject\Id $id
     * @param \App\Domain\Log\LoginLogs\ValueObject\LoginId $login_id
     * @param \App\Domain\Log\LoginLogs\ValueObject\LoginActorType $login_actor_type
     * @param \App\Domain\Log\LoginLogs\ValueObject\AccountId $account_id
     * @param \App\Domain\Log\LoginLogs\ValueObject\ImpersonatorAccountId $impersonator_account_id
     * @param \App\Domain\Log\LoginLogs\ValueObject\LoginResult $login_result
     * @param \App\Domain\Log\LoginLogs\ValueObject\IpAddress $ip_address
     * @param \App\Domain\Log\LoginLogs\ValueObject\UserAgent $user_agent
     * @param \App\Domain\Log\LoginLogs\ValueObject\FailureReasonCode $failure_reason_code
     * @param \App\Domain\Log\LoginLogs\ValueObject\LoggedInAt $logged_in_at
     * @param \App\Domain\Shared\ValueObject\Created $created_at
     */
    public function __construct(
        private readonly Vo\Id $id,
        private readonly Vo\LoginId $login_id,
        private readonly Vo\LoginActorType $login_actor_type,
        private readonly Vo\AccountId $account_id,
        private readonly Vo\ImpersonatorAccountId $impersonator_account_id,
        private readonly Vo\LoginResult $login_result,
        private readonly Vo\IpAddress $ip_address,
        private readonly Vo\UserAgent $user_agent,
        private readonly Vo\FailureReasonCode $failure_reason_code,
        private readonly Vo\LoggedInAt $logged_in_at,
        private readonly SVo\CreatedAt $created_at,
    ) {
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\Id
     */
    public function id(): Vo\Id
    {
        return $this->id;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\LoginId
     */
    public function loginId(): Vo\LoginId
    {
        return $this->login_id;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\LoginActorType
     */
    public function loginActorType(): Vo\LoginActorType
    {
        return $this->login_actor_type;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\AccountId
     */
    public function accountId(): Vo\AccountId
    {
        return $this->account_id;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\ImpersonatorAccountId
     */
    public function impersonatorAccountId(): Vo\ImpersonatorAccountId
    {
        return $this->impersonator_account_id;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\LoginResult
     */
    public function loginResult(): Vo\LoginResult
    {
        return $this->login_result;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\IpAddress
     */
    public function ipAddress(): Vo\IpAddress
    {
        return $this->ip_address;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\UserAgent
     */
    public function userAgent(): Vo\UserAgent
    {
        return $this->user_agent;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\FailureReasonCode
     */
    public function failureReasonCode(): Vo\FailureReasonCode
    {
        return $this->failure_reason_code;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\LoggedInAt
     */
    public function loggedInAt(): Vo\LoggedInAt
    {
        return $this->logged_in_at;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\Created
     */
    public function createdAt(): SVo\CreatedAt
    {
        return $this->created_at;
    }
}
