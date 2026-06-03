<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\Entity;

use App\Domain\User\UserGrant\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use DomainException;

final class GrantRole
{
    /**
     * @param \App\Domain\User\UserGrant\ValueObject\GrantRoleId $grant_role_id
     * @param \App\Domain\User\UserGrant\ValueObject\Code $code
     * @param \App\Domain\User\UserGrant\ValueObject\Name $name
     * @param \App\Domain\User\UserGrant\ValueObject\Description $description
     * @param \App\Domain\User\UserGrant\ValueObject\Sort $sort
     * @param \App\Domain\User\UserGrant\ValueObject\IsActive $is_active
     * @param \App\Domain\Shared\ValueObject\Created $created_at
     * @param \App\Domain\Shared\ValueObject\Modified $modified_at
     * @param array<\App\Domain\User\UserGrant\Entity\GrantAccountRole> $grant_account_roles
     * @param array<\App\Domain\User\UserGrant\Entity\GrantRolePermission> $grant_role_permissions
     */
    public function __construct(
        private readonly Vo\GrantRoleId $grant_role_id,
        private readonly Vo\Code $code,
        private readonly Vo\Name $name,
        private readonly Vo\Description $description,
        private readonly Vo\Sort $sort,
        private readonly Vo\IsActive $is_active,
        private readonly SVo\CreatedAt $created_at,
        private readonly SVo\ModifiedAt $modified_at,
        private array $grant_account_roles = [],
        private array $grant_role_permissions = [],
    ) {
        foreach ($this->grant_account_roles as $grant_account_role) {
            if (!$grant_account_role->hasGrantRoleId($this->grant_role_id)) {
                throw new DomainException('GrantAccountRole grant_role_id does not match grant_role_id');
            }
        }

        foreach ($this->grant_role_permissions as $grant_role_permission) {
            if (!$grant_role_permission->hasGrantRoleId($this->grant_role_id)) {
                throw new DomainException('GrantRolePermission grant_role_id does not match grant_role_id');
            }
        }
    }

    /**
     * 関連する付与ロールを設定する
     *
     * @param array<\App\Domain\User\UserGrant\Entity\GrantAccountRole> $grant_account_roles
     * @return self
     */
    public function assignGrantAccountRoles(array $grant_account_roles): self
    {
        foreach ($grant_account_roles as $grant_account_role) {
            if (!$grant_account_role->hasGrantRoleId($this->grant_role_id)) {
                throw new DomainException('GrantAccountRole grant_role_id does not match grant_role_id');
            }
        }

        $ther = clone $this;
        $ther->grant_account_roles = $grant_account_roles;

        return $ther;
    }

    /**
     * 関連するロール権限を設定する
     *
     * @param array<\App\Domain\User\UserGrant\Entity\GrantRolePermission> $grant_role_permissions
     * @return self
     */
    public function assignGrantRolePermissions(array $grant_role_permissions): self
    {
        foreach ($grant_role_permissions as $grant_role_permission) {
            if (!$grant_role_permission->hasGrantRoleId($this->grant_role_id)) {
                throw new DomainException('GrantRolePermission grant_role_id does not match grant_role_id');
            }
        }

        $ther = clone $this;
        $ther->grant_role_permissions = $grant_role_permissions;

        return $ther;
    }

    /**
     * @param \App\Domain\User\UserGrant\ValueObject\GrantRoleId $grant_role_id
     * @return bool
     */
    public function hasGrantRoleId(Vo\GrantRoleId $grant_role_id): bool
    {
        return $this->grant_role_id->toString() === $grant_role_id->toString();
    }

    /**
     * @param \App\Domain\User\UserGrant\ValueObject\Code $code
     * @return bool
     */
    public function hasPermissionCode(Vo\Code $code): bool
    {
        return array_filter(
            $this->grant_role_permissions,
            fn($grant_role_permission) => $grant_role_permission->hasPermissionCode($code),
        ) !== [];
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\GrantRoleId
     */
    public function grantRoleId(): Vo\GrantRoleId
    {
        return $this->grant_role_id;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\Code
     */
    public function code(): Vo\Code
    {
        return $this->code;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\Name
     */
    public function name(): Vo\Name
    {
        return $this->name;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\Description
     */
    public function description(): Vo\Description
    {
        return $this->description;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\Sort
     */
    public function sort(): Vo\Sort
    {
        return $this->sort;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\IsActive
     */
    public function isActive(): Vo\IsActive
    {
        return $this->is_active;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\Created
     */
    public function createdAt(): SVo\CreatedAt
    {
        return $this->created_at;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\Modified
     */
    public function modifiedAt(): SVo\ModifiedAt
    {
        return $this->modified_at;
    }

    /**
     * @return array<\App\Domain\User\UserGrant\Entity\GrantAccountRole>
     */
    public function grantAccountRoles(): array
    {
        return $this->grant_account_roles;
    }

    /**
     * @return array<\App\Domain\User\UserGrant\Entity\GrantRolePermission>
     */
    public function grantRolePermissions(): array
    {
        return $this->grant_role_permissions;
    }
}
