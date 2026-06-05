<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\LoginLogs;

use App\Domain\Log\LoginLogs\Entity\LoginLog as DomainEntity;
use App\Domain\Log\LoginLogs\Repository\LoginLogsRepository as DomainRepository;
use App\Domain\Log\LoginLogs\SearchCondition;
use App\Domain\Log\LoginLogs\ValueObject as Vo;
use App\Models\Log\LoginLog as EloquentModel;
use Illuminate\Support\Carbon;

final class LoginLogsRepository implements DomainRepository
{
    public function search(SearchCondition $condition): array
    {
        return (new Search())->run($condition);
    }

    public function create(DomainEntity $entity): DomainEntity
    {
        return (new Create())->run($entity);
    }

    public function read(Vo\Id $id): DomainEntity
    {
        return (new Read())->run($id);
    }

    public function checkFailureLoginLimit(Vo\LoginId $loginId): bool
    {
        return (new CheckFailureLoginLimit())->run($loginId);
    }
}
