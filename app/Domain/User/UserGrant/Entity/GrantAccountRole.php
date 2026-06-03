<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\Entity;

use App\Domain\User\UserGrant\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use DomainException;

final class GrantAccountRole
{
    /**
     * @param \App\Domain\User\UserGrant\ValueObject\GrantAccountRoleId $grant_account_role_id
     * @param \App\Domain\User\UserGrant\ValueObject\UserAccountId $user_account_id
     * @param \App\Domain\User\UserGrant\ValueObject\GrantRoleId $grant_role_id
     * @param \App\Domain\Shared\ValueObject\Created $created
     * @param \App\Domain\Shared\ValueObject\Modified $modified
     * @param ?\App\Domain\User\UserGrant\Entity\UserAccountGrant $user_account_grant
     * @param ?\App\Domain\User\UserGrant\Entity\GrantRole $grant_role
     */
    public function __construct(
        private readonly Vo\GrantAccountRoleId $grant_account_role_id,
        private readonly Vo\UserAccountId $user_account_id,
        private readonly Vo\GrantRoleId $grant_role_id,
        private readonly SVo\Created $created,
        private readonly SVo\Modified $modified,
        private ?UserAccountGrant $user_account_grant,
        private ?GrantRole $grant_role,
    ) {
        if (
            $this->user_account_grant !== null
            && !$this->user_account_grant->hasUserAccountId($this->user_account_id)
        ) {
            throw new DomainException('GrantAccountGrant user_account_id does not match user_account_id');
        }

        if (
            $this->grant_role !== null
            && !$this->grant_role->hasGrantRoleId($this->grant_role_id)
        ) {
            throw new DomainException('GrantRole id does not match grant_role_id');
        }
    }

    /**
     * @param \App\Domain\User\UserGrant\Entity\UserAccountGrant $user_account_grant
     * @return self
     */
    public function assignUserAccountGrant(UserAccountGrant $user_account_grant): self
    {
        if (!$user_account_grant->hasUserAccountId($this->user_account_id)) {
            throw new DomainException('GrantAccountGrant user_account_id does not match user_account_id');
        }

        $ther = clone $this;
        $ther->user_account_grant = $user_account_grant;

        return $ther;
    }

    /**
     * @param \App\Domain\User\UserGrant\Entity\GrantRole $grant_role
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
     * @param \App\Domain\User\UserGrant\ValueObject\UserAccountId $user_account_id
     * @return bool
     */
    public function hasUserAccountId(Vo\UserAccountId $user_account_id): bool
    {
        return $this->user_account_id->toString() === $user_account_id->toString();
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
        return $this->grant_role !== null
            && $this->grant_role->hasPermissionCode($code);
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\GrantAccountRoleId
     */
    public function grantAccountRoleId(): Vo\GrantAccountRoleId
    {
        return $this->grant_account_role_id;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\UserAccountId
     */
    public function userAccountId(): Vo\UserAccountId
    {
        return $this->user_account_id;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\GrantRoleId
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
     * @return ?\App\Domain\User\UserGrant\Entity\UserAccountGrant
     */
    public function userAccountGrant(): ?UserAccountGrant
    {
        return $this->user_account_grant;
    }

    /**
     * @return ?\App\Domain\User\UserGrant\Entity\GrantRole
     */
    public function grantRole(): ?GrantRole
    {
        return $this->grant_role;
    }
}
