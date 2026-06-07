<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\PageAccessLogs;

use App\Domain\Log\PageAccessLogs\Entity\PageAccessLog as DomainEntity;
use App\Domain\Log\PageAccessLogs\Repository\PageAccessLogsRepository as DomainRepository;
use App\Domain\Log\PageAccessLogs\SearchCondition;
use DateTimeInterface;

final class PageAccessLogsRepository implements DomainRepository
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // no-op
    }

    /**
     * @param \App\Domain\Log\PageAccessLogs\SearchCondition $condition
     * @return array<\App\Domain\Log\PageAccessLogs\Entity\PageAccessLog>
     */
    public function search(SearchCondition $condition): array
    {
        return (new PageAccessLogsRepository\Search($this->datetime))->run($condition);
    }

    /**
     * @param \App\Domain\Log\PageAccessLogs\Entity\PageAccessLog $entity
     * @return \App\Domain\Log\PageAccessLogs\Entity\PageAccessLog
     */
    public function create(DomainEntity $entity): DomainEntity
    {
        return (new PageAccessLogsRepository\Create($this->datetime))->run($entity);
    }
}
