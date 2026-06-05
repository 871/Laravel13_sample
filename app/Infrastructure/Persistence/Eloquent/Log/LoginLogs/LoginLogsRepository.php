<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\LoginLogs;

use App\Domain\Log\LoginLogs\Entity\LoginLog as DomainEntity;
use App\Domain\Log\LoginLogs\Repository\LoginLogsRepository as DomainRepository;
use App\Domain\Log\LoginLogs\SearchCondition;
use App\Domain\Log\LoginLogs\ValueObject as Vo;
use DateTimeInterface;

final class LoginLogsRepository implements DomainRepository
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
        return (new LoginLogsRepository\Search($this->datetime))->run($condition);
    }

    public function create(DomainEntity $entity): DomainEntity
    {
        return (new LoginLogsRepository\Create($this->datetime))->run($entity);
    }

    public function read(Vo\Id $id): DomainEntity
    {
        return (new LoginLogsRepository\Read($this->datetime))->run($id);
    }

    public function checkFailureLoginLimit(Vo\LoginId $loginId): bool
    {
        return (new LoginLogsRepository\CheckFailureLoginLimit($this->datetime))->run($loginId);
    }
}
