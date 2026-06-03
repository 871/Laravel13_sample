<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant\Entity;

use App\Domain\Admin\AdminGrant\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use DomainException;

final class GrantAccountRole
{
    /**
     * @param \App\Domain\Admin\AdminGrant\ValueObject\GrantAccountRoleId $grant_account_role_id
     * @param \App\Domain\Admin\AdminGrant\ValueObject\AdminAccountId $admin_account_id
     * @param \App\Domain\Admin\AdminGrant\ValueObject\GrantRoleId $grant_role_id
     * @param \App\Domain\Shared\ValueObject\Created $created
     * @param \App\Domain\Shared\ValueObject\Modified $modified
     * @param ?\App\Domain\Admin\AdminGrant\Entity\AdminAccountGrant $admin_account_grant
     * @param ?\App\Domain\Admin\AdminGrant\Entity\GrantRole $grant_role
     */
    public function __construct(
        private readonly Vo\GrantAccountRoleId $grant_account_role_id,
        private readonly Vo\AdminAccountId $admin_account_id,
        private readonly Vo\GrantRoleId $grant_role_id,
        private readonly SVo\Created $created,
        private readonly SVo\Modified $modified,
        private ?AdminAccountGrant $admin_account_grant,
        private ?GrantRole $grant_role,
    ) {
        if (
            $this->admin_account_grant !== null
            && !$this->admin_account_grant->hasAdminAccountId($this->admin_account_id)
        ) {
            throw new DomainException('GrantAccountGrant admin_account_id does not match admin_account_id');
        }

        if (
            $this->grant_role !== null
            && !$this->grant_role->hasGrantRoleId($this->grant_role_id)
        ) {
            throw new DomainException('GrantRole id does not match grant_role_id');
        }
    }

    /**
     * @param \App\Domain\Admin\AdminGrant\Entity\AdminAccountGrant $admin_account_grant
     * @return self
     */
    public function assignAdminAccountGrant(AdminAccountGrant $admin_account_grant): self
    {
        if (!$admin_account_grant->hasAdminAccountId($this->admin_account_id)) {
            throw new DomainException('GrantAccountGrant admin_account_id does not match admin_account_id');
        }

        $ther = clone $this;
        $ther->admin_account_grant = $admin_account_grant;

        return $ther;
    }

    /**
     * @param \App\Domain\Admin\AdminGrant\Entity\GrantRole $grant_role
     * @return self
     */
    public function assignGrantRole(GrantRole $grant_role): self
    {
        if (!$grant_role->hasGrantRoleId($this->grant_role_id)) {
            throw new DomainException('GrantRole id does not match grant_role_id');
        }

        $ther = clone $this;
        $ther->grant_role = $grant_role;

        return $ther;
    }

    /**
     * @param \App\Domain\Admin\AdminGrant\ValueObject\AdminAccountId $admin_account_id
     * @return bool
     */
    public function hasAdminAccountId(Vo\AdminAccountId $admin_account_id): bool
    {
        return $this->admin_account_id->toString() === $admin_account_id->toString();
    }

    /**
     * @param \App\Domain\Admin\AdminGrant\ValueObject\GrantRoleId $grant_role_id
     * @return bool
     */
    public function hasGrantRoleId(Vo\GrantRoleId $grant_role_id): bool
    {
        return $this->grant_role_id->toString() === $grant_role_id->toString();
    }

    /**
     * @param \App\Domain\Admin\AdminGrant\ValueObject\Code $code
     * @return bool
     */
    public function hasPermissionCode(Vo\Code $code): bool
    {
        return $this->grant_role !== null
            && $this->grant_role->hasPermissionCode($code);
    }

    /**
     * @return \App\Domain\Admin\AdminGrant\ValueObject\GrantAccountRoleId
     */
    public function grantAccountRoleId(): Vo\GrantAccountRoleId
    {
        return $this->grant_account_role_id;
    }

    /**
     * @return \App\Domain\Admin\AdminGrant\ValueObject\AdminAccountId
     */
    public function adminAccountId(): Vo\AdminAccountId
    {
        return $this->admin_account_id;
    }

    /**
     * @return \App\Domain\Admin\AdminGrant\ValueObject\GrantRoleId
     */
    public function grantRoleId(): Vo\GrantRoleId
    {
        return $this->grant_role_id;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\Created
     */
    public function created(): SVo\Created
    {
        return $this->created;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\Modified
     */
    public function modified(): SVo\Modified
    {
        return $this->modified;
    }

    /**
     * @return ?\App\Domain\Admin\AdminGrant\Entity\AdminAccountGrant
     */
    public function adminAccountGrant(): ?AdminAccountGrant
    {
        return $this->admin_account_grant;
    }

    /**
     * @return ?\App\Domain\Admin\AdminGrant\Entity\GrantRole
     */
    public function grantRole(): ?GrantRole
    {
        return $this->grant_role;
    }
}
