<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant;

use App\Domain\Admin\AdminGrant\ValueObject\IsActive;
use App\Domain\Shared\ValueObject\SearchText;

class SearchAdminGrantPermissionCondition
{
    /**
     * @param \App\Domain\Shared\ValueObject\SearchText $searchText
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
     * @return \App\Domain\Admin\AdminGrant\ValueObject\IsActive
     */
    public function getIsActive(): IsActive
    {
        return $this->isActive;
    }
}
