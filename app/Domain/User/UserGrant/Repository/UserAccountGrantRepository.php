<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\Repository;

use App\Domain\User\UserGrant\Entity\UserAccountGrant;
use App\Domain\User\UserGrant\SearchUserAccountGrantCondition;
use App\Domain\User\UserGrant\ValueObject as Vo;
use Cake\ORM\Query\SelectQuery;
use DateTimeInterface;

interface UserAccountGrantRepository
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(DateTimeInterface $datetime);

    /**
     * @param \App\Domain\User\UserGrant\SearchUserAccountGrantCondition $condition
     * @return \App\Domain\User\UserGrant\Entity\UserAccountGrant[]
     */
    public function search(SearchUserAccountGrantCondition $condition): array;

    /**
     * @return array<\App\Domain\User\UserGrant\Entity\AccountStatusMaster>
     */
    public function findAccountStatusMasters(): array;

    /**
     * @param \App\Domain\User\UserGrant\ValueObject\UserAccountId $userAccountId
     * @return \App\Domain\User\UserGrant\Entity\UserAccountGrant
     */
    public function detail(Vo\UserAccountId $userAccountId): UserAccountGrant;

    /**
     * @param \App\Domain\User\UserGrant\Entity\UserAccountGrant $userAccountGrant
     * @return \App\Domain\User\UserGrant\Entity\UserAccountGrant
     */
    public function save(UserAccountGrant $userAccountGrant): UserAccountGrant;
}
