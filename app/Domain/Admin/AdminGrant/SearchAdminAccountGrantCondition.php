<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant;

class SearchAdminAccountGrantCondition
{
    /**
     * @param array<\App\Domain\Admin\AdminGrant\ValueObject\AdminAccountId> $adminAccountIds
     * @param array<\App\Domain\Admin\AdminGrant\ValueObject\AccountStatusMasterId> $accountStatusMasterIds
     * @param array<\App\Domain\Admin\AdminGrant\ValueObject\GrantRoleId> $grantRoleIds
     * @param array<\App\Domain\Admin\AdminGrant\ValueObject\GrantPermissionId> $grantPermissionIds
     */
    public function __construct(
        /** @var array<\App\Domain\Admin\AdminGrant\ValueObject\AdminAccountId> */
        private readonly array $adminAccountIds,
        /** @var array<\App\Domain\Admin\AdminGrant\ValueObject\AccountStatusMasterId> */
        private readonly array $accountStatusMasterIds,
        /** @var array<\App\Domain\Admin\AdminGrant\ValueObject\GrantRoleId> */
        private readonly array $grantRoleIds,
        /** @var array<\App\Domain\Admin\AdminGrant\ValueObject\GrantPermissionId> */
        private readonly array $grantPermissionIds,
    ) {
        // 処理なし
    }

    /**
     * @return array<\App\Domain\Admin\AdminGrant\ValueObject\AdminAccountId>
     */
    public function getAdminAccountIds(): array
    {
        return $this->adminAccountIds;
    }

    /**
     * @return array<\App\Domain\Admin\AdminGrant\ValueObject\AccountStatusMasterId>
     */
    public function getAccountStatusMasterIds(): array
    {
        return $this->accountStatusMasterIds;
    }

    /**
     * @return array<\App\Domain\Admin\AdminGrant\ValueObject\GrantRoleId>
     */
    public function getGrantRoleIds(): array
    {
        return $this->grantRoleIds;
    }

    /**
     * @return array<\App\Domain\Admin\AdminGrant\ValueObject\GrantPermissionId>
     */
    public function getGrantPermissionIds(): array
    {
        return $this->grantPermissionIds;
    }
}
