<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant\Entity;

use App\Domain\Admin\AdminGrant\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use DomainException;

final class GrantRolePermission
{
    /**
     * @param \App\Domain\Admin\AdminGrant\ValueObject\GrantRolePermissionId $grant_role_permission_id
     * @param \App\Domain\Admin\AdminGrant\ValueObject\GrantRoleId $grant_role_id
     * @param \App\Domain\Admin\AdminGrant\ValueObject\GrantPermissionId $grant_permission_id
     * @param \App\Domain\Shared\ValueObject\Created $created_at
     * @param \App\Domain\Shared\ValueObject\Modified $modified_at
     * @param \App\Domain\Admin\AdminGrant\Entity\GrantRole|null $grant_role
     * @param \App\Domain\Admin\AdminGrant\Entity\GrantPermission|null $grant_permission
     */
    public function __construct(
        private readonly Vo\GrantRolePermissionId $grant_role_permission_id,
        private readonly Vo\GrantRoleId $grant_role_id,
        private readonly Vo\GrantPermissionId $grant_permission_id,
        private readonly SVo\CreatedAt $created_at,
        private readonly SVo\ModifiedAt $modified_at,
        private readonly ?GrantRole $grant_role,
        private readonly ?GrantPermission $grant_permission,
    ) {
        if (
            $this->grant_role !== null
            && !$this->grant_role->hasGrantRoleId($grant_role_id)
        ) {
            throw new DomainException('GrantRole grant_role_id does not match grant_role_id');
        }

        if (
            $this->grant_permission !== null
            && !$this->grant_permission->hasGrantPermissionId($this->grant_permission_id)
        ) {
            throw new DomainException('GrantPermission id does not match grant_permission_id');
        }
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
     */
    public function hasPermissionCode(Vo\Code $code): bool
    {
        return $this->grant_permission !== null
            && $this->grant_permission->hasCode($code);
    }

    /**
     * @return \App\Domain\Admin\AdminGrant\ValueObject\GrantRolePermissionId
     */
    public function grantRolePermissionId(): Vo\GrantRolePermissionId
    {
        return $this->grant_role_permission_id;
    }

    /**
     * @return \App\Domain\Admin\AdminGrant\ValueObject\GrantRoleId
     */
    public function grantRoleId(): Vo\GrantRoleId
    {
        return $this->grant_role_id;
    }

    /**
     * @return \App\Domain\Admin\AdminGrant\ValueObject\GrantPermissionId
     */
    public function grantPermissionId(): Vo\GrantPermissionId
    {
        return $this->grant_permission_id;
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
     * @return ?\App\Domain\Admin\AdminGrant\Entity\GrantPermission
     */
    public function grantPermission(): ?GrantPermission
    {
        return $this->grant_permission;
    }
}
