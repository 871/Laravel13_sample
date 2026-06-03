<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\Entity;

use App\Domain\User\UserGrant\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use DomainException;

final class GrantRolePermission
{
    /**
     * @param \App\Domain\User\UserGrant\ValueObject\GrantRolePermissionId $grant_role_permission_id
     * @param \App\Domain\User\UserGrant\ValueObject\GrantRoleId $grant_role_id
     * @param \App\Domain\User\UserGrant\ValueObject\GrantPermissionId $grant_permission_id
     * @param \App\Domain\Shared\ValueObject\Created $created
     * @param \App\Domain\Shared\ValueObject\Modified $modified
     * @param \App\Domain\User\UserGrant\Entity\GrantRole|null $grant_role
     * @param \App\Domain\User\UserGrant\Entity\GrantPermission|null $grant_permission
     */
    public function __construct(
        private readonly Vo\GrantRolePermissionId $grant_role_permission_id,
        private readonly Vo\GrantRoleId $grant_role_id,
        private readonly Vo\GrantPermissionId $grant_permission_id,
        private readonly SVo\Created $created,
        private readonly SVo\Modified $modified,
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
     * @param \App\Domain\User\UserGrant\ValueObject\GrantRoleId $grant_role_id
     * @return bool
     */
    public function hasGrantRoleId(Vo\GrantRoleId $grant_role_id): bool
    {
        return $this->grant_role_id->toString() === $grant_role_id->toString();
    }

    /**
     * @param \App\Domain\User\UserGrant\ValueObject\Code $code
     */
    public function hasPermissionCode(Vo\Code $code): bool
    {
        return $this->grant_permission !== null
            && $this->grant_permission->hasCode($code);
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\GrantRolePermissionId
     */
    public function grantRolePermissionId(): Vo\GrantRolePermissionId
    {
        return $this->grant_role_permission_id;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\GrantRoleId
     */
    public function grantRoleId(): Vo\GrantRoleId
    {
        return $this->grant_role_id;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\GrantPermissionId
     */
    public function grantPermissionId(): Vo\GrantPermissionId
    {
        return $this->grant_permission_id;
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
     * @return ?\App\Domain\User\UserGrant\Entity\GrantPermission
     */
    public function grantPermission(): ?GrantPermission
    {
        return $this->grant_permission;
    }
}
