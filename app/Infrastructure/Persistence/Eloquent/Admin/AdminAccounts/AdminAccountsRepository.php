<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccounts;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Domain\Admin\AdminAccounts\Repository\AdminAccountsRepository as DomainRepository;
use App\Domain\Admin\AdminAccounts\SearchCondition;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use DateTimeInterface;

final class AdminAccountsRepository implements DomainRepository
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // 処理なし
    }

    public function search(SearchCondition $condition): array
    {
        return (new AdminAccountsRepository\Search($this->datetime))->run($condition);
    }

    public function create(DomainEntity $entity): DomainEntity
    {
        return (new AdminAccountsRepository\Create($this->datetime))->run($entity);
    }

    public function read(Vo\Id $id): DomainEntity
    {
        return (new AdminAccountsRepository\Read($this->datetime))->run($id);
    }

    public function update(DomainEntity $entity): DomainEntity
    {
        return (new AdminAccountsRepository\Update($this->datetime))->run($entity);
    }

    public function readHistories(Vo\Id $adminAccountId): array
    {
        return (new AdminAccountsRepository\ReadHistories($this->datetime))->run($adminAccountId);
    }

    public function findByEmail(Vo\Email $email): ?DomainEntity
    {
        return (new AdminAccountsRepository\FindByEmail($this->datetime))->run($email);
    }
}
