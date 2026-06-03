<?php
declare(strict_types=1);

namespace App\Domain\Log\PageAccessLogs;

class SearchCondition
{
    public const DEFAULT_LIMIT = 100;

    /**
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\Accessed $accessedFrom
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\Accessed $accessedTo
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\Search\AccountType $accountType
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\Search\AccountId $accountId
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\Search\Keyword $keyword
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\Search\NavigationType $navigationType
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\SearchKey $searchKey
     * @param int $limit
     */
    public function __construct(
        private readonly ValueObject\Accessed $accessedFrom,
        private readonly ValueObject\Accessed $accessedTo,
        private readonly ValueObject\Search\AccountType $accountType,
        private readonly ValueObject\Search\AccountId $accountId,
        private readonly ValueObject\Search\Keyword $keyword,
        private readonly ValueObject\Search\NavigationType $navigationType,
        private readonly ValueObject\SearchKey $searchKey,
        private readonly int $limit = self::DEFAULT_LIMIT,
    ) {
        // 処理なし
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\Accessed
     */
    public function getAccessedFrom(): ValueObject\Accessed
    {
        return $this->accessedFrom;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\Accessed
     */
    public function getAccessedTo(): ValueObject\Accessed
    {
        return $this->accessedTo;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\Search\AccountType
     */
    public function getAccountType(): ValueObject\Search\AccountType
    {
        return $this->accountType;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\Search\AccountId
     */
    public function getAccountId(): ValueObject\Search\AccountId
    {
        return $this->accountId;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\Search\Keyword
     */
    public function getKeyword(): ValueObject\Search\Keyword
    {
        return $this->keyword;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\Search\NavigationType
     */
    public function getNavigationType(): ValueObject\Search\NavigationType
    {
        return $this->navigationType;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\SearchKey
     */
    public function getSearchKey(): ValueObject\SearchKey
    {
        return $this->searchKey;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }
}
