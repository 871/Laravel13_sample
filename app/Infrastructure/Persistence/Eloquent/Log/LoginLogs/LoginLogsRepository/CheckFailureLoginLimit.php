<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\LoginLogs\LoginLogsRepository;

use App\Domain\Log\LoginLogs\ValueObject as Vo;
use App\Models\Log\LoginLog;
use Illuminate\Support\Carbon;
use DateTimeInterface;

final class CheckFailureLoginLimit
{
    // Defaults; can be overridden via config('auth.login_failure_threshold') and config('auth.login_failure_minutes')
    private const DEFAULT_FAILURE_LOGIN_LIMIT = 5; // ログイン失敗回数の上限
    private const DEFAULT_FAILURE_LOGIN_MINUTES = 30; // ログイン失敗回数をカウントする時間

    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // 処理なし
    }

    public function run(Vo\LoginId $loginId): bool
    {
        // Memo: ロック状態では新たなログは記録されないため、ログイン失敗の上限回数を超えたかどうかは、
        // 上限回数分のログを取得して、失敗のログが上限回数未満かどうかで判断する。
        // KEY `login_logs_idx04` (`login_id`,`logged_in_at`)
        $limit = (int)config('auth.login_failure_threshold', self::DEFAULT_FAILURE_LOGIN_LIMIT);
        $minutes = (int)config('auth.login_failure_minutes', self::DEFAULT_FAILURE_LOGIN_MINUTES);

        return LoginLog::query()
            ->where('login_logs.login_id', $loginId->toString())
            ->where('login_logs.logged_in_at', '>=', Carbon::parse($this->datetime)
                ->subMinutes($minutes)
                ->format('Y-m-d H:i:s')
            )
            ->orderByDesc('login_logs.logged_in_at')
            ->limit($limit)
            ->get(['login_result'])
            ->filter(fn(LoginLog $log) => $log->login_result === Vo\LoginResult::FAILURE)
            ->count() < $limit;
    }
}
