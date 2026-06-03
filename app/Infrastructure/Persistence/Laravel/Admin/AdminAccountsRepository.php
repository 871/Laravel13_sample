<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Laravel\Admin;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Domain\Admin\AdminAccounts\Entity\AdminAccountHistory as DomainHistoryEntity;
use App\Domain\Admin\AdminAccounts\Repository\AdminAccountsRepository as DomainRepository;
use App\Domain\Admin\AdminAccounts\SearchCondition;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use App\Models\Admin\AdminAccount as EloquentModel;
use App\Models\Admin\AdminAccountHistory as EloquentHistory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

final class AdminAccountsRepository implements DomainRepository
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(private readonly DateTimeInterface $datetime)
    {
    }

    public function search(SearchCondition $condition): array
    {
        return (new AdminAccountsRepository\Search($condition))->run();
    }

    public function create(DomainEntity $entity): DomainEntity
    {
        return (new AdminAccountsRepository\Create($entity))->run();
    }

    public function read(Vo\Id $id): DomainEntity
    {
        return (new AdminAccountsRepository\Read($id))->run();
    }

    public function update(DomainEntity $entity): DomainEntity
    {
        return (new AdminAccountsRepository\Update($entity))->run();
    }

    public function delete(Vo\Id $id): DomainEntity
    {
        return (new AdminAccountsRepository\Delete($id, $this->datetime))->run();
    }

    public function readHistories(Vo\Id $adminAccountId): array
    {
        return (new AdminAccountsRepository\ReadHistories($adminAccountId))->run();
    }

    public function findByEmail(Vo\Email $email): ?DomainEntity
    {
        return (new AdminAccountsRepository\FindByEmail($email))->run();
    }
}
