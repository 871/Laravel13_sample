<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant;

use App\Domain\Shared\ValueObject\SearchText;

class SearchAdminGrantRoleCondition
{
    /**
     * @param \App\Domain\Shared\ValueObject\SearchText $searchText
     * @param array<\App\Domain\Admin\AdminGrant\ValueObject\IsActive> $isActives
     * @param array<\App\Domain\Admin\AdminGrant\ValueObject\GrantPermissionId> $grantPermissionIds
     */
    public function __construct(
        private readonly SearchText $searchText,
        private readonly array $isActives = [],
        private readonly array $grantPermissionIds = [],
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
     * @return array<\App\Domain\Admin\AdminGrant\ValueObject\IsActive>
     */
    public function getIsActives(): array
    {
        return $this->isActives;
    }

    /**
     * @return array<\App\Domain\Admin\AdminGrant\ValueObject\GrantPermissionId>
     */
    public function getGrantPermissionIds(): array
    {
        return $this->grantPermissionIds;
    }
}
