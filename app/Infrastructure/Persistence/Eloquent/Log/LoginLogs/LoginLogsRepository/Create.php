<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\LoginLogs\LoginLogsRepository;

use App\Domain\Log\LoginLogs\Entity\LoginLog as DomainEntity;
use App\Models\Log\LoginLog;
use DateTimeInterface;

final class Create
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // 処理なし
    }

    public function run(DomainEntity $entity): DomainEntity
    {
        $loginLog = LoginLog::create([
            'id' => $entity->id()->toString(),
            'login_id' => $entity->loginId()->toString(),
            'login_actor_type' => $entity->loginActorType()->toString(),
            'account_id' => $entity->accountId()->toIntOrNull(),
            'impersonator_account_id' => $entity->impersonatorAccountId()->toIntOrNull(),
            'login_result' => $entity->loginResult()->toString(),
            'ip_address' => $entity->ipAddress()->toString(),
            'user_agent' => $entity->userAgent()->toStringOrNull(),
            'failure_reason_code' => $entity->failureReasonCode()->toStringOrNull(),
            'logged_in_at' => $entity->loggedInAt()->toString(),
            'created_at' => $entity->createdAt()->toString(),
        ]);

        return Mapper::mapModelToDomain($loginLog);
    }
}
