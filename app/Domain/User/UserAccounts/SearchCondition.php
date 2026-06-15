<?php
declare(strict_types=1);

namespace App\Domain\User\UserAccounts;

class SearchCondition
{
    /**
     * @param \App\Domain\User\UserAccounts\ValueObject\Id $id
     * @param \App\Domain\User\UserAccounts\ValueObject\Search\Keyword $keyword
     * @param \App\Domain\User\UserAccounts\ValueObject\AccountStatusMasterId $accountStatusMasterId
     * @param \App\Domain\User\UserAccounts\ValueObject\Search\OrderBy $orderBy
     * @param int $perPage
     * @param int $page
     */
    public function __construct(
        private readonly ValueObject\Id $id,
        private readonly ValueObject\Search\Keyword $keyword,
        private readonly ValueObject\AccountStatusMasterId $accountStatusMasterId,
        private readonly ValueObject\Search\OrderBy $orderBy = new ValueObject\Search\OrderBy('user_accounts.created_at', ValueObject\Search\OrderBy::DESC),
        private readonly int $perPage = 20,
        private readonly int $page = 1
    ) {
        // 処理なし
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\Id
     */
    public function getId(): ValueObject\Id
    {
        return $this->id;
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\Search\Keyword
     */
    public function getKeyword(): ValueObject\Search\Keyword
    {
        return $this->keyword;
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\AccountStatusMasterId
     */
    public function getAccountStatusMasterId(): ValueObject\AccountStatusMasterId
    {
        return $this->accountStatusMasterId;
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\Search\OrderBy
     */
    public function getOrderBy(): ValueObject\Search\OrderBy
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