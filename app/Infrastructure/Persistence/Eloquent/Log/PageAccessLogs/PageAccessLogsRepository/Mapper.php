<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\PageAccessLogs\PageAccessLogsRepository;

use App\Domain\Log\PageAccessLogs\Entity\PageAccessLog as DomainEntity;
use App\Domain\Log\PageAccessLogs\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use App\Models\Log\PageAccessLog as EloquentModel;

final class Mapper
{
    public static function mapModelToDomain(EloquentModel $m): DomainEntity
    {
        return new DomainEntity(
            new Vo\Id((string)$m->id),
            new Vo\Accessed((
                $m->accessed instanceof \DateTimeInterface
                    ? $m->accessed->format('Y-m-d\\TH:i:s')
                    : ($m->accessed ?? null)
            )),
            new Vo\AccountType((string)$m->account_type),
            new Vo\AccountId(isset($m->account_id) ? (string)$m->account_id : null),
            new Vo\Method((string)$m->method),
            new Vo\Path((string)$m->path),
            new Vo\QueryString($m->query_string ?? null),
            new Vo\PostKeys($m->post_keys ?? null),
            new Vo\RouteName($m->route_name ?? null),
            new Vo\Referer($m->referer ?? null),
            new Vo\IpAddress($m->ip_address ?? null),
            new Vo\UserAgent($m->user_agent ?? null),
            new SVo\CreatedAt((
                $m->created_at instanceof \DateTimeInterface
                    ? $m->created_at->format('Y-m-d\\TH:i:s')
                    : ($m->created_at ?? null)
            )),
            new Vo\SearchKey((string)$m->search_key),
        );
    }
}
