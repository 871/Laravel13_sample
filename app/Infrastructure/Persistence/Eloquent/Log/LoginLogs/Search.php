<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\LoginLogs;

use App\Domain\Log\LoginLogs\SearchCondition;
use App\Models\Log\LoginLog as EloquentModel;
use Illuminate\Support\Carbon;

final class Search
{
    public function run(SearchCondition $condition): array
    {
        $query = EloquentModel::query();

        $types = $condition->getLoginActorType();
        if (!empty($types)) {
            $typeValues = array_map(fn($t) => (string)$t->toString(), $types);
            $query->whereIn('login_actor_type', $typeValues);
        }

        $accountId = $condition->getAccountId()->toStringOrNull();
        if ($accountId !== null) {
            $query->where('account_id', $accountId);
        }

        $impersonatorId = $condition->getImpersonatorAccountId()->toStringOrNull();
        if ($impersonatorId !== null) {
            $query->where('impersonator_account_id', $impersonatorId);
        }

        $loginResult = $condition->getLoginResult();
        if (!empty($loginResult)) {
            $vals = array_map(fn($v) => (string)$v->toString(), $loginResult);
            $query->whereIn('login_result', $vals);
        }

        $failureCodes = $condition->getFailureReasonCode();
        if (!empty($failureCodes)) {
            $vals = array_map(fn($v) => (string)$v->toString(), $failureCodes);
            $query->whereIn('failure_reason_code', $vals);
        }

        $from = $condition->getLoggedInAtFrom()->toStringOrNull();
        if ($from !== null) {
            $query->where('logged_in_at', '>=', Carbon::parse($from));
        }

        $to = $condition->getLoggedInAtTo()->toStringOrNull();
        if ($to !== null) {
            $query->where('logged_in_at', '<=', Carbon::parse($to));
        }

        $keyword = $condition->getKeyword()->toQueryLikeOrNull();
        if ($keyword !== null) {
            $query->where(function($q) use ($keyword) {
                $q->where('login_id', 'like', $keyword)
                  ->orWhere('ip_address', 'like', $keyword)
                  ->orWhere('user_agent', 'like', $keyword);
            });
        }

        $models = $query->orderBy('logged_in_at', 'desc')->get();

        return $models->map(fn($m) => Mapper::mapModelToDomain($m))->toArray();
    }
}
