<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\Entity;

use App\Domain\User\UserGrant\ValueObject as Vo;
use DomainException;

final class UserAccountGrant
{
    /**
     * @param \App\Domain\User\UserGrant\ValueObject\UserAccountId $user_account_id
     * @param \App\Domain\User\UserGrant\ValueObject\Email $email
     * @param \App\Domain\User\UserGrant\ValueObject\Name $name
     * @param \App\Domain\User\UserGrant\ValueObject\AccountStatusMasterId $account_status_master_id
     * @param \App\Domain\User\UserGrant\ValueObject\AccountStatusMasterCode $account_status_master_code
     * @param \App\Domain\User\UserGrant\ValueObject\AccountStatusMasterName $account_status_master_name
     * @param array<\App\Domain\User\UserGrant\Entity\GrantAccountRole> $grant_account_roles
     * @param array<\App\Domain\User\UserGrant\Entity\GrantAccountPermission> $grant_account_permissions
     */
    public function __construct(
        private readonly Vo\UserAccountId $user_account_id,
        private readonly Vo\Email $email,
        private readonly Vo\Name $name,
        private readonly Vo\AccountStatusMasterId $account_status_master_id,
        private readonly Vo\AccountStatusMasterCode $account_status_master_code,
        private readonly Vo\AccountStatusMasterName $account_status_master_name,
        private array $grant_account_roles = [],
        private array $grant_account_permissions = [],
    ) {
        foreach ($this->grant_account_roles as $grant_role) {
            if (!$grant_role->hasUserAccountId($this->user_account_id)) {
                throw new DomainException('GrantAccountRole user_account_id does not match UserAccountId');
            }
        }

        foreach ($this->grant_account_permissions as $grant_account_permission) {
            if (!$grant_account_permission->hasUserAccountId($this->user_account_id)) {
                throw new DomainException('GrantAccountPermission user_account_id does not match UserAccountId');
            }
        }
    }

    /**
     * @param array<\App\Domain\User\UserGrant\Entity\GrantAccountRole> $grant_account_roles
     * @return self
     */
    public function assignGrantAccountRoles(array $grant_account_roles): self
    {
        foreach ($grant_account_roles as $grant_account_role) {
            if (!$grant_account_role->hasUserAccountId($this->user_account_id)) {
                throw new DomainException('GrantAccountRole user_account_id does not match UserAccountId');
            }
        }

        $ther = clone $this;
        $ther->grant_account_roles = $grant_account_roles;

        return $ther;
    }

    /**
     * @param array<\App\Domain\User\UserGrant\Entity\GrantAccountPermission> $grant_account_permissions
     * @return self
     */
    public function assignGrantAccountPermissions(array $grant_account_permissions): self
    {
        foreach ($grant_account_permissions as $grant_account_permission) {
            if (!$grant_account_permission->hasUserAccountId($this->user_account_id)) {
                throw new DomainException('GrantAccountPermission user_account_id does not match UserAccountId');
            }
        }

        $ther = clone $this;
        $ther->grant_account_permissions = $grant_account_permissions;

        return $ther;
    }

    /**
     * @param \App\Domain\User\UserGrant\ValueObject\UserAccountId $id
     * @return bool
     */
    public function hasUserAccountId(Vo\UserAccountId $id): bool
    {
        return $this->user_account_id->toString() === $id->toString();
    }

    /**
     * @param \App\Domain\User\UserGrant\ValueObject\Code $code
     */
    public function hasPermissionCode(Vo\Code $code): bool
    {
        foreach ($this->grant_account_permissions as $grant_account_permission) {
            if ($grant_account_permission->hasPermissionCode($code)) {
                return true;
            }
        }

        foreach ($this->grant_account_roles as $grant_account_role) {
            if ($grant_account_role->hasPermissionCode($code)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \App\Domain\User\UserGrant\ValueObject\Code $code
     * @return list<string>
     */
    public function grantSettings(Vo\Code $code): array
    {
        $settings = [];

        foreach ($this->grant_account_permissions as $grant_account_permission) {
            if ($grant_account_permission->hasPermissionCode($code)) {
                $settings[] = 'アカウント付与';
                break;
            }
        }

        foreach ($this->grant_account_roles as $grant_account_role) {
            if ($grant_account_role->hasPermissionCode($code)) {
                $grant_role = $grant_account_role->grantRole();
                if ($grant_role !== null) {
                    $settings[] = $grant_role->name()->toString();
                }
            }
        }

        return $settings;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\UserAccountId
     */
    public function userAccountId(): Vo\UserAccountId
    {
        return $this->user_account_id;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\Email
     */
    public function email(): Vo\Email
    {
        return $this->email;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\Name
     */
    public function name(): Vo\Name
    {
        return $this->name;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\AccountStatusMasterId
     */
    public function accountStatusMasterId(): Vo\AccountStatusMasterId
    {
        return $this->account_status_master_id;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\AccountStatusMasterCode
     */
    public function accountStatusMasterCode(): Vo\AccountStatusMasterCode
    {
        return $this->account_status_master_code;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\AccountStatusMasterName
     */
    public function accountStatusMasterName(): Vo\AccountStatusMasterName
    {
        return $this->account_status_master_name;
    }

    /**
     * @return array<\App\Domain\User\UserGrant\Entity\GrantAccountRole>
     */
    public function grantAccountRoles(): array
    {
        return $this->grant_account_roles;
    }

    /**
     * @return array<\App\Domain\User\UserGrant\Entity\GrantAccountPermission>
     */
    public function grantAccountPermissions(): array
    {
        return $this->grant_account_permissions;
    }
}
