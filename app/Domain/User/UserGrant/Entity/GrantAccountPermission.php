<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\Entity;

use App\Domain\User\UserGrant\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use DomainException;

final class GrantAccountPermission
{
    /**
     * @param \App\Domain\User\UserGrant\ValueObject\GrantAccountPermissionId $grant_account_permission_id
     * @param \App\Domain\User\UserGrant\ValueObject\UserAccountId $user_account_id
     * @param \App\Domain\User\UserGrant\ValueObject\GrantPermissionId $grant_permission_id
     * @param \App\Domain\Shared\ValueObject\Created $created
     * @param \App\Domain\Shared\ValueObject\Modified $modified
     * @param ?\App\Domain\User\UserGrant\Entity\UserAccountGrant $user_account_grant
     * @param ?\App\Domain\User\UserGrant\Entity\GrantPermission $grant_permission
     */
    public function __construct(
        private readonly Vo\GrantAccountPermissionId $grant_account_permission_id,
        private readonly Vo\UserAccountId $user_account_id,
        private readonly Vo\GrantPermissionId $grant_permission_id,
        private readonly SVo\Created $created,
        private readonly SVo\Modified $modified,
        private ?UserAccountGrant $user_account_grant,
        private ?GrantPermission $grant_permission,
    ) {
        if (
            $user_account_grant !== null
            && !$user_account_grant->hasUserAccountId($user_account_id)
        ) {
            throw new DomainException('UserAccountGrant does not have the specified user_account_id');
        }

        if (
            $this->grant_permission !== null
            && !$this->grant_permission->hasGrantPermissionId($this->grant_permission_id)
        ) {
            throw new DomainException('GrantPermission id does not match grant_permission_id');
        }
    }

    /**
     * @param \App\Domain\User\UserGrant\Entity\UserAccountGrant $user_account_grant
     * @return self
     */
    public function assignUserAccountGrant(UserAccountGrant $user_account_grant): self
    {
        if (!$user_account_grant->hasUserAccountId($this->user_account_id)) {
            throw new DomainException('UserAccountGrant does not have the specified user_account_id');
        }

        $ther = clone $this;
        $ther->user_account_grant = $user_account_grant;

        return $ther;
    }

    /**
     * @param \App\Domain\User\UserGrant\Entity\GrantPermission $grant_permission
     * @return self
     */
    public function assignGrantPermission(GrantPermission $grant_permission): self
    {
        if (!$grant_permission->hasGrantPermissionId($this->grant_permission_id)) {
            throw new DomainException('GrantPermission id does not match grant_permission_id');
        }
        $ther = clone $this;
        $ther->grant_permission = $grant_permission;

        return $ther;
    }

    /**
     * @param \App\Domain\User\UserGrant\ValueObject\UserAccountId $user_account_id
     * @return bool
     */
    public function hasUserAccountId(Vo\UserAccountId $user_account_id): bool
    {
        return $this->user_account_id->toString() === $user_account_id->toString();
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
     * @return \App\Domain\User\UserGrant\ValueObject\GrantAccountPermissionId
     */
    public function grantAccountPermissionId(): Vo\GrantAccountPermissionId
    {
        return $this->grant_account_permission_id;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\UserAccountId
     */
    public function userAccountId(): Vo\UserAccountId
    {
        return $this->user_account_id;
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
     * @return ?\App\Domain\User\UserGrant\Entity\UserAccountGrant
     */
    public function userAccountGrant(): ?UserAccountGrant
    {
        return $this->user_account_grant;
    }

    /**
     * @return ?\App\Domain\User\UserGrant\Entity\GrantPermission
     */
    public function grantPermission(): ?GrantPermission
    {
        return $this->grant_permission;
    }
}
