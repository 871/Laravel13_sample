<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\Repository;

use App\Domain\User\UserGrant\Entity\GrantRole;
use App\Domain\User\UserGrant\SearchUserGrantRoleCondition;
use App\Domain\User\UserGrant\ValueObject as Vo;
use Cake\ORM\Query\SelectQuery;
use DateTimeInterface;

interface UserGrantRoleRepository
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(DateTimeInterface $datetime);

    /**
     * @param \App\Domain\User\UserGrant\SearchUserGrantRoleCondition $condition
     * @return array<\App\Domain\User\UserGrant\Entity\GrantRole>
     */
    public function query(SearchUserGrantRoleCondition $condition): array;

    /**
     * @param \App\Domain\User\UserGrant\SearchUserGrantRoleCondition $condition
     * @return array<\App\Domain\User\UserGrant\Entity\GrantRole>
     */
    public function search(SearchUserGrantRoleCondition $condition): array;

    /**
     * @param \App\Domain\User\UserGrant\Entity\GrantRole $entity
     * @return \App\Domain\User\UserGrant\Entity\GrantRole
     */
    public function create(GrantRole $entity): GrantRole;

    /**
     * @param \App\Domain\User\UserGrant\ValueObject\GrantRoleId $id
     * @return \App\Domain\User\UserGrant\Entity\GrantRole
     */
    public function read(Vo\GrantRoleId $id): GrantRole;

    /**
     * @param \App\Domain\User\UserGrant\Entity\GrantRole $entity
     * @return \App\Domain\User\UserGrant\Entity\GrantRole
     */
    public function update(GrantRole $entity): GrantRole;

    /**
     * @param \App\Domain\User\UserGrant\Entity\GrantRole $entity
     * @return \App\Domain\User\UserGrant\Entity\GrantRole
     */
    public function delete(GrantRole $entity): GrantRole;
}
