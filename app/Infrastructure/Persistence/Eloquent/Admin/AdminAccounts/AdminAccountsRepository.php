<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccounts;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Domain\Admin\AdminAccounts\Repository\AdminAccountsRepository as DomainRepository;
use App\Domain\Admin\AdminAccounts\SearchCondition;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as Svo;
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

    /**
     * @return array
     */
    public function search(SearchCondition $condition): array
    {
        return (new AdminAccountsRepository\Search($this->datetime))->run($condition);
    }

    public function create(DomainEntity $entity): DomainEntity
    {
        return (new AdminAccountsRepository\Create($this->datetime))->run($entity);
    }

    public function read(Vo\Id $id, ?Svo\ModifiedAt $modifiedAt = null): DomainEntity
    {
        return (new AdminAccountsRepository\Read($this->datetime))->run($id, $modifiedAt);
    }

    public function update(DomainEntity $entity): DomainEntity
    {
        return (new AdminAccountsRepository\Update($this->datetime))->run($entity);
    }

    public function delete(Vo\Id $id): DomainEntity
    {
        return (new AdminAccountsRepository\Delete($this->datetime))->run($id);
    }

    public function readHistories(Vo\Id $adminAccountId): array
    {
        return (new AdminAccountsRepository\ReadHistories($this->datetime))->run($adminAccountId);
    }

    public function findByEmail(Vo\Email $email): ?DomainEntity
    {
        return (new AdminAccountsRepository\FindByEmail($this->datetime))->run($email);
    }

    public function getAccountStatusOptions(): array
    {
        return (new AdminAccountsRepository\GetAccountStatusOptions($this->datetime))->run();
    }
}
