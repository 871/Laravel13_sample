<?php
declare(strict_types=1);

namespace App\Domain\User\UserAccounts\Repository;

use App\Domain\User\UserAccounts\Entity\UserAccount;
use App\Domain\User\UserAccounts\SearchCondition;
use App\Domain\User\UserAccounts\ValueObject as Vo;
use DateTimeInterface;

interface UserAccountsRepository
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(DateTimeInterface $datetime);

    /**
     * @param \App\Domain\User\UserAccounts\SearchCondition $condition
     * @return \App\Domain\User\UserAccounts\Entity\UserAccount[]
     */
    public function search(SearchCondition $condition): array;

    /**
     * @param \App\Domain\User\UserAccounts\Entity\UserAccount $entity
     * @return \App\Domain\User\UserAccounts\Entity\UserAccount
     */
    public function create(UserAccount $entity): UserAccount;

    /**
     * @param \App\Domain\User\UserAccounts\ValueObject\Id $id
     * @return \App\Domain\User\UserAccounts\Entity\UserAccount
     */
    public function read(Vo\Id $id): UserAccount;

    /**
     * @param \App\Domain\User\UserAccounts\Entity\UserAccount $entity
     * @return \App\Domain\User\UserAccounts\Entity\UserAccount
     */
    public function update(UserAccount $entity): UserAccount;

    /**
     * @param \App\Domain\User\UserAccounts\ValueObject\Id $id
     * @return \App\Domain\User\UserAccounts\Entity\UserAccount
     */
    public function delete(Vo\Id $id): UserAccount;

    /**
     * @param \App\Domain\User\UserAccounts\ValueObject\Id $userAccountId
     * @return array<\App\Domain\User\UserAccounts\Entity\UserAccountHistory>
     */
    public function readHistories(Vo\Id $userAccountId): array;

    /**
     * @param \App\Domain\User\UserAccounts\ValueObject\Email $email
     * @return ?\App\Domain\User\UserAccounts\Entity\UserAccount
     */
    public function findByEmail(Vo\Email $email): ?UserAccount;

    /**
     * @return \App\Domain\User\UserAccounts\Entity\AccountStatusMaster[]
     */
    public function getAccountStatusOptions(): array;
}
