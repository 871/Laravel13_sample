<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\Repository;

use App\Domain\User\UserGrant\Entity\GrantPermission;
use App\Domain\User\UserGrant\SearchUserGrantPermissionCondition;
use App\Domain\User\UserGrant\ValueObject as Vo;
use DateTimeInterface;

interface UserGrantPermissionRepository
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(DateTimeInterface $datetime);

    /**
     * @param \App\Domain\User\UserGrant\SearchUserGrantPermissionCondition $condition
     * @return array<GrantPermission>
     */
    public function search(SearchUserGrantPermissionCondition $condition): array;

    /**
     * @param \App\Domain\User\UserGrant\ValueObject\Code $code
     * @param \App\Domain\User\UserGrant\ValueObject\UserAccountId $accountId
     * @return bool
     */
    public function hasPermission(Vo\Code $code, Vo\UserAccountId $accountId): bool;

    /**
     * @param GrantPermission $entity
     * @return GrantPermission
     */
    public function create(GrantPermission $entity): GrantPermission;

    /**
     * @param Vo\GrantPermissionId $id
     * @return GrantPermission
     */
    public function read(Vo\GrantPermissionId $id): GrantPermission;

    /**
     * @param GrantPermission $entity
     * @return GrantPermission
     */
    public function update(GrantPermission $entity): GrantPermission;

    /**
     * @param GrantPermission $entity
     * @return GrantPermission
     */
    public function delete(GrantPermission $entity): GrantPermission;
}
