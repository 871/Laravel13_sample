<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\PageAccessLogs\PageAccessLogsRepository;

use App\Domain\Log\PageAccessLogs\Entity\PageAccessLog as DomainEntity;
use App\Models\Log\PageAccessLog as EloquentModel;
use DateTimeInterface;

final class Create
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // no-op
    }

    public function run(DomainEntity $entity): DomainEntity
    {
        $m = EloquentModel::create([
            'id' => $entity->id()->toString(),
            'accessed' => $entity->accessed()->format('Y-m-d\\TH:i:s.u'),
            'account_type' => $entity->accountType()->toString(),
            'account_id' => $entity->accountId()->toInt(),
            'method' => $entity->method()->toString(),
            'path' => $entity->path()->toString(),
            'query_string' => $entity->queryString()->toStringOrNull(),
            'post_keys' => $entity->postKeys()->toStringOrNull(),
            'route_name' => $entity->routeName()->toStringOrNull(),
            'referer' => $entity->referer()->toStringOrNull(),
            'ip_address' => $entity->ipAddress()->toStringOrNull(),
            'user_agent' => $entity->userAgent()->toStringOrNull(),
            'created_at' => $entity->createdAt()->toString(),
        ]);

        return Mapper::mapModelToDomain($m);
    }
}
