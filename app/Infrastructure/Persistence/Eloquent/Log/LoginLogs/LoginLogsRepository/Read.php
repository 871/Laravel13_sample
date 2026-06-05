<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\LoginLogs\LoginLogsRepository;

use App\Domain\Log\LoginLogs\ValueObject as Vo;
use App\Models\Log\LoginLog;
use DateTimeInterface;

final class Read
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // 処理なし
    }

    public function run(Vo\Id $id)
    {
        $m = LoginLog::query()
            ->select(
                'login_logs.id',
                'login_logs.login_id',
                'login_logs.login_actor_type',
                'login_logs.account_id',
                'login_logs.impersonator_account_id',
                'login_logs.login_result',
                'login_logs.ip_address',
                'login_logs.user_agent',
                'login_logs.failure_reason_code',
                'login_logs.logged_in_at',
                'login_logs.created_at',
            )
            ->where('login_logs.id', $id->toString())
            ->firstOrFail();

        return Mapper::mapModelToDomain($m);
    }
}
