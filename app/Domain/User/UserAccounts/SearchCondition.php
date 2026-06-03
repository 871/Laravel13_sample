<?php
declare(strict_types=1);

namespace App\Domain\User\UserAccounts;

class SearchCondition
{
    /**
     * @param \App\Domain\User\UserAccounts\ValueObject\Id $id
     * @param \App\Domain\User\UserAccounts\ValueObject\Search\Keyword $keyword
     * @param \App\Domain\User\UserAccounts\ValueObject\AccountStatusMasterId $accountStatusMasterId
     */
    public function __construct(
        private readonly ValueObject\Id $id,
        private readonly ValueObject\Search\Keyword $keyword,
        private readonly ValueObject\AccountStatusMasterId $accountStatusMasterId,
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
}
