<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminAccounts;

use App\Domain\Shared\ValueObject as SVo;

class SearchCondition
{
    /**
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\Id $id
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\Search\Keyword $keyword
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterId $accountStatusMasterId
     * @param \App\Domain\Shared\ValueObject\OrderBy $orderBy
     * @param int $perPage
     * @param int $page
     */
    public function __construct(
        private readonly ValueObject\Id $id,
        private readonly ValueObject\Search\Keyword $keyword,
        private readonly ValueObject\AccountStatusMasterId $accountStatusMasterId,
        private readonly SVo\OrderBy $orderBy = new SVo\OrderBy('admin_accounts.created_at', SVo\OrderBy::DESC),
        private readonly int $perPage = 20,
        private readonly int $page = 1
    ) {
        // 処理なし
    }

    /**
     * @return \App\Domain\Admin\AdminAccounts\ValueObject\Id
     */
    public function getId(): ValueObject\Id
    {
        return $this->id;
    }

    /**
     * @return \App\Domain\Admin\AdminAccounts\ValueObject\Search\Keyword
     */
    public function getKeyword(): ValueObject\Search\Keyword
    {
        return $this->keyword;
    }

    /**
     * @return \App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterId
     */
    public function getAccountStatusMasterId(): ValueObject\AccountStatusMasterId
    {
        return $this->accountStatusMasterId;
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