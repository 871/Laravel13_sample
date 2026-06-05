<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\LoginLogs;

use App\Domain\Log\LoginLogs\ValueObject\LoginId as LoginIdVo;
use App\Models\Log\LoginLog as EloquentModel;
use Illuminate\Support\Carbon;

final class CheckFailureLoginLimit
{
    public function run(LoginIdVo $loginId): bool
    {
        $threshold = config('auth.login_failure_threshold', 5);
        $minutes = config('auth.login_failure_minutes', 15);

        $count = EloquentModel::query()
            ->where('login_id', $loginId->toString())
            ->where('login_result', 'FAILURE')
            ->where('logged_in_at', '>=', Carbon::now()->subMinutes($minutes))
            ->count();

        return $count < $threshold;
    }
}
