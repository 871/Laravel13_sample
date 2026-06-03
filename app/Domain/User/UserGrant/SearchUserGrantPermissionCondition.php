<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant;

use App\Domain\User\UserGrant\ValueObject\IsActive;
use App\Domain\Shared\ValueObject\SearchText;

class SearchUserGrantPermissionCondition
{
    /**
     * @param \App\Domain\Shared\ValueObject\SearchText $searchText
     * @param \App\Domain\User\UserGrant\ValueObject\IsActive $isActive
     */
    public function __construct(
        private readonly SearchText $searchText,
        private readonly IsActive $isActive,
    ) {
        // 処理なし
    }

    /**
     * @return \App\Domain\Shared\ValueObject\SearchText
     */
    public function getSearchText(): SearchText
    {
        return $this->searchText;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\IsActive
     */
    public function getIsActive(): IsActive
    {
        return $this->isActive;
    }
}
