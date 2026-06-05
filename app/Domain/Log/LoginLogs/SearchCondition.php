<?php
declare(strict_types=1);

namespace App\Domain\Log\LoginLogs;

use App\Domain\Shared\ValueObject as SVo;

class SearchCondition
{
    /**
     * @param array<\App\Domain\Log\LoginLogs\ValueObject\LoginActorType> $loginActorType
     * @param \App\Domain\Log\LoginLogs\ValueObject\AccountId $accountId
     * @param \App\Domain\Log\LoginLogs\ValueObject\ImpersonatorAccountId $impersonatorAccountId
     * @param array<\App\Domain\Log\LoginLogs\ValueObject\LoginResult> $loginResult
     * @param array<\App\Domain\Log\LoginLogs\ValueObject\FailureReasonCode> $failureReasonCode
     * @param \App\Domain\Log\LoginLogs\ValueObject\LoggedInAt $loggedInAtFrom
     * @param \App\Domain\Log\LoginLogs\ValueObject\LoggedInAt $loggedInAtTo
     * @param \App\Domain\Log\LoginLogs\ValueObject\Search\Keyword $keyword
     * @param \App\Domain\Shared\ValueObject\OrderBy $orderBy
     * @param int $perPage
     * @param int $page
     */
    public function __construct(
        /** @var array<\App\Domain\Log\LoginLogs\ValueObject\LoginActorType> */
        private readonly array $loginActorType,
        private readonly ValueObject\AccountId $accountId,
        private readonly ValueObject\ImpersonatorAccountId $impersonatorAccountId,
        /** @var array<\App\Domain\Log\LoginLogs\ValueObject\LoginResult> */
        private readonly array $loginResult,
        /** @var array<\App\Domain\Log\LoginLogs\ValueObject\FailureReasonCode> */
        private readonly array $failureReasonCode,
        private readonly ValueObject\LoggedInAt $loggedInAtFrom,
        private readonly ValueObject\LoggedInAt $loggedInAtTo,
        private readonly ValueObject\Search\Keyword $keyword,
        private readonly SVo\OrderBy $orderBy = new SVo\OrderBy('login_logs.logged_in_at', SVo\OrderBy::DESC),
        private readonly int $perPage = 20,
        private readonly int $page = 1
    ) {
        // 処理なし
    }

    /**
     * @return array<\App\Domain\Log\LoginLogs\ValueObject\LoginActorType>
     */
    public function getLoginActorType(): array
    {
        return $this->loginActorType;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\AccountId
     */
    public function getAccountId(): ValueObject\AccountId
    {
        return $this->accountId;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\ImpersonatorAccountId
     */
    public function getImpersonatorAccountId(): ValueObject\ImpersonatorAccountId
    {
        return $this->impersonatorAccountId;
    }

    /**
     * @return array<\App\Domain\Log\LoginLogs\ValueObject\LoginResult>
     */
    public function getLoginResult(): array
    {
        return $this->loginResult;
    }

    /**
     * @return array<\App\Domain\Log\LoginLogs\ValueObject\FailureReasonCode>
     */
    public function getFailureReasonCode(): array
    {
        return $this->failureReasonCode;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\LoggedInAt
     */
    public function getLoggedInAtFrom(): ValueObject\LoggedInAt
    {
        return $this->loggedInAtFrom;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\LoggedInAt
     */
    public function getLoggedInAtTo(): ValueObject\LoggedInAt
    {
        return $this->loggedInAtTo;
    }

    /**
     * @return \App\Domain\Log\LoginLogs\ValueObject\Search\Keyword
     */
    public function getKeyword(): ValueObject\Search\Keyword
    {
        return $this->keyword;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\OrderBy
     */
    public function getOrderBy(): SVo\OrderBy
    {
        return $this->orderBy;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }
}