<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\Entity;

use App\Domain\User\UserGrant\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;

final class GrantPermission
{
    /**
     * @param \App\Domain\User\UserGrant\ValueObject\GrantPermissionId $grant_permission_id
     * @param \App\Domain\User\UserGrant\ValueObject\Code $code
     * @param \App\Domain\User\UserGrant\ValueObject\Name $name
     * @param \App\Domain\User\UserGrant\ValueObject\Description $description
     * @param \App\Domain\User\UserGrant\ValueObject\Sort $sort
     * @param \App\Domain\User\UserGrant\ValueObject\IsActive $is_active
     * @param \App\Domain\Shared\ValueObject\Created $created_at
     * @param \App\Domain\Shared\ValueObject\Modified $modified_at
     */
    public function __construct(
        private readonly Vo\GrantPermissionId $grant_permission_id,
        private readonly Vo\Code $code,
        private readonly Vo\Name $name,
        private readonly Vo\Description $description,
        private readonly Vo\Sort $sort,
        private readonly Vo\IsActive $is_active,
        private readonly SVo\CreatedAt $created_at,
        private readonly SVo\ModifiedAt $modified_at,
    ) {
    }

    /**
     * @param \App\Domain\User\UserGrant\ValueObject\GrantPermissionId $grant_permission_id
     * @return bool
     */
    public function hasGrantPermissionId(Vo\GrantPermissionId $grant_permission_id): bool
    {
        return $this->grant_permission_id->toString() === $grant_permission_id->toString();
    }

    /**
     * @param \App\Domain\User\UserGrant\ValueObject\Code $code
     * @return bool
     */
    public function hasCode(Vo\Code $code): bool
    {
        return $this->code->toString() === $code->toString();
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\GrantPermissionId
     */
    public function grantPermissionId(): Vo\GrantPermissionId
    {
        return $this->grant_permission_id;
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
}
