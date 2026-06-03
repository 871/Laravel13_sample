<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant;

class SearchUserAccountGrantCondition
{
    /**
     * @param array<\App\Domain\User\UserGrant\ValueObject\UserAccountId> $userAccountIds
     * @param array<\App\Domain\User\UserGrant\ValueObject\AccountStatusMasterId> $accountStatusMasterIds
     * @param array<\App\Domain\User\UserGrant\ValueObject\GrantRoleId> $grantRoleIds
     * @param array<\App\Domain\User\UserGrant\ValueObject\GrantPermissionId> $grantPermissionIds
     */
    public function __construct(
        /** @var array<\App\Domain\User\UserGrant\ValueObject\UserAccountId> */
        private readonly array $userAccountIds,
        /** @var array<\App\Domain\User\UserGrant\ValueObject\AccountStatusMasterId> */
        private readonly array $accountStatusMasterIds,
        /** @var array<\App\Domain\User\UserGrant\ValueObject\GrantRoleId> */
        private readonly array $grantRoleIds,
        /** @var array<\App\Domain\User\UserGrant\ValueObject\GrantPermissionId> */
        private readonly array $grantPermissionIds,
    ) {
        // 処理なし
    }

    /**
     * @return array<\App\Domain\User\UserGrant\ValueObject\UserAccountId>
     */
    public function getUserAccountIds(): array
    {
        return $this->userAccountIds;
    }

    /**
     * @return array<\App\Domain\User\UserGrant\ValueObject\AccountStatusMasterId>
     */
    public function getAccountStatusMasterIds(): array
    {
        return $this->accountStatusMasterIds;
    }

    /**
     * @return array<\App\Domain\User\UserGrant\ValueObject\GrantRoleId>
     */
    public function getGrantRoleIds(): array
    {
        return $this->grantRoleIds;
    }

    /**
     * @return array<\App\Domain\User\UserGrant\ValueObject\GrantPermissionId>
     */
    public function getGrantPermissionIds(): array
    {
        return $this->grantPermissionIds;
    }
}
