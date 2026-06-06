<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\LoginLogs\LoginLogsRepository;

use App\Domain\Log\LoginLogs\Entity\LoginLog as DomainEntity;
use App\Domain\Log\LoginLogs\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use App\Models\Log\LoginLog as EloquentModel;

final class Mapper
{
    public static function mapModelToDomain(EloquentModel $m): DomainEntity
    {
        return new DomainEntity(
            new Vo\Id((string)$m->id),
            new Vo\LoginId((string)$m->login_id),
            new Vo\LoginActorType((string)$m->login_actor_type),
            new Vo\AccountId(isset($m->account_id) && $m->account_id !== null ? (string)$m->account_id : null),
            new Vo\ImpersonatorAccountId(isset($m->impersonator_account_id) && $m->impersonator_account_id !== null ? (string)$m->impersonator_account_id : null),
            new Vo\LoginResult((string)$m->login_result),
            new Vo\IpAddress((string)$m->ip_address),
            new Vo\UserAgent($m->user_agent ?? null),
            new Vo\FailureReasonCode($m->failure_reason_code ?? null),
            new Vo\LoggedInAt((
                $m->logged_in_at instanceof \DateTimeInterface
                    ? $m->logged_in_at->format('Y-m-d\\TH:i:s')
                    : ($m->logged_in_at ?? null)
            )),
            new SVo\CreatedAt((
                $m->created_at instanceof \DateTimeInterface
                    ? $m->created_at->format('Y-m-d\\TH:i:s')
                    : ($m->created_at ?? null)
            )),
        );
    }
}
