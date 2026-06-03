<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant\Entity;

use App\Domain\Admin\AdminGrant\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use DomainException;

final class GrantAccountPermission
{
    /**
     * @param \App\Domain\Admin\AdminGrant\ValueObject\GrantAccountPermissionId $grant_account_permission_id
     * @param \App\Domain\Admin\AdminGrant\ValueObject\AdminAccountId $admin_account_id
     * @param \App\Domain\Admin\AdminGrant\ValueObject\GrantPermissionId $grant_permission_id
     * @param \App\Domain\Shared\ValueObject\Created $created_at
     * @param \App\Domain\Shared\ValueObject\Modified $modified_at
     */
    public function __construct(
        private readonly Vo\GrantAccountPermissionId $grant_account_permission_id,
        private readonly Vo\AdminAccountId $admin_account_id,
        private readonly Vo\GrantPermissionId $grant_permission_id,
        private readonly SVo\CreatedAt $created_at,
        private readonly SVo\ModifiedAt $modified_at,
        private ?AdminAccountGrant $admin_account_grant,
        private ?GrantPermission $grant_permission,
    ) {
        if (
            $admin_account_grant !== null
            && !$admin_account_grant->hasAdminAccountId($admin_account_id)
        ) {
            throw new DomainException('AdminAccountGrant does not have the specified admin_account_id');
        }

        if (
            $this->grant_permission !== null
            && !$this->grant_permission->hasGrantPermissionId($this->grant_permission_id)
        ) {
            throw new DomainException('GrantPermission id does not match grant_permission_id');
        }
    }

    /**
     * 関連する管理者権限を設定する
     *
     * @param \App\Domain\Admin\AdminGrant\Entity\AdminAccountGrant $admin_account_grant
     * @return self
     */
    public function assignAdminAccountGrant(AdminAccountGrant $admin_account_grant): self
    {
        if (!$admin_account_grant->hasAdminAccountId($this->admin_account_id)) {
            throw new DomainException('AdminAccountGrant does not have the specified admin_account_id');
        }

        $ther = clone $this;
        $ther->admin_account_grant = $admin_account_grant;

        return $ther;
    }

    /**
     * 関連する権限情報を設定する
     *
     * @param \App\Domain\Admin\AdminGrant\Entity\GrantPermission $grant_permission
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
     * @param \App\Domain\Admin\AdminGrant\ValueObject\AdminAccountId $admin_account_id
     * @return bool
     */
    public function hasAdminAccountId(Vo\AdminAccountId $admin_account_id): bool
    {
        return $this->admin_account_id->toString() === $admin_account_id->toString();
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
     * @return \App\Domain\Admin\AdminGrant\ValueObject\GrantAccountPermissionId
     */
    public function grantAccountPermissionId(): Vo\GrantAccountPermissionId
    {
        return $this->grant_account_permission_id;
    }

    /**
     * @return \App\Domain\Admin\AdminGrant\ValueObject\AdminAccountId
     */
    public function adminAccountId(): Vo\AdminAccountId
    {
        return $this->admin_account_id;
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
     * @return \App\Domain\Admin\AdminGrant\Entity\AdminAccountGrant|null
     */
    public function adminAccountGrant(): ?AdminAccountGrant
    {
        return $this->admin_account_grant;
    }

    /**
     * @return \App\Domain\Admin\AdminGrant\Entity\GrantPermission|null
     */
    public function grantPermission(): ?GrantPermission
    {
        return $this->grant_permission;
    }
}
