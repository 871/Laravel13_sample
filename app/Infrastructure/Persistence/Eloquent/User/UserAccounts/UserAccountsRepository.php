<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\User\UserAccounts;

use App\Domain\User\UserAccounts\Entity\UserAccount as DomainEntity;
use App\Domain\User\UserAccounts\Repository\UserAccountsRepository as DomainRepository;
use App\Domain\User\UserAccounts\SearchCondition;
use App\Domain\User\UserAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as Svo;
use DateTimeInterface;

final class UserAccountsRepository implements DomainRepository
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // no-op
    }

    /**
     * @return array
     */
    public function search(SearchCondition $condition): array
    {
        return (new UserAccountsRepository\Search($this->datetime))->run($condition);
    }

    public function create(DomainEntity $entity): DomainEntity
    {
        return (new UserAccountsRepository\Create($this->datetime))->run($entity);
    }

    public function read(Vo\Id $id, ?Svo\ModifiedAt $modifiedAt = null): DomainEntity
    {
        return (new UserAccountsRepository\Read($this->datetime))->run($id, $modifiedAt);
    }

    public function update(DomainEntity $entity): DomainEntity
    {
        return (new UserAccountsRepository\Update($this->datetime))->run($entity);
    }

    public function delete(Vo\Id $id): DomainEntity
    {
        return (new UserAccountsRepository\Delete($this->datetime))->run($id);
    }

    public function readHistories(Vo\Id $userAccountId): array
    {
        return (new UserAccountsRepository\ReadHistories($this->datetime))->run($userAccountId);
    }

    public function findByEmail(Vo\Email $email): ?DomainEntity
    {
        return (new UserAccountsRepository\FindByEmail($this->datetime))->run($email);
    }

    public function getAccountStatusOptions(): array
    {
        return (new UserAccountsRepository\GetAccountStatusOptions($this->datetime))->run();
    }
}
