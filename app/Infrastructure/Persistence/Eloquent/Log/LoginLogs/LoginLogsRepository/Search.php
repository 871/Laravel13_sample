<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\LoginLogs\LoginLogsRepository;

use App\Domain\Log\LoginLogs\SearchCondition;
use App\Infrastructure\Persistence\Eloquent\Log\LoginLogs\Mapper;
use App\Models\Log\LoginLog as EloquentModel;
use Illuminate\Support\Carbon;
use DateTimeInterface;

final class Search
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // 処理なし
    }

    public function run(SearchCondition $condition): array
    {
        $types = $condition->getLoginActorType();
        $accountId = $condition->getAccountId()->toStringOrNull();
        $impersonatorId = $condition->getImpersonatorAccountId()->toStringOrNull();
        $loginResult = $condition->getLoginResult();
        $failureCodes = $condition->getFailureReasonCode();
        $from = $condition->getLoggedInAtFrom()->toStringOrNull();
        $to = $condition->getLoggedInAtTo()->toStringOrNull();
        $keyword = $condition->getKeyword()->toQueryLikeOrNull();

        $query = EloquentModel::query()
            ->when(!empty($types), function ($q) use ($types) {
                $typeValues = array_map(fn($t) => (string)$t->toString(), $types);
                $q->whereIn('login_actor_type', $typeValues);
            })
            ->when($accountId !== null, function ($q) use ($accountId) {
                $q->where('account_id', $accountId);
            })
            ->when($impersonatorId !== null, function ($q) use ($impersonatorId) {
                $q->where('impersonator_account_id', $impersonatorId);
            })
            ->when(!empty($loginResult), function ($q) use ($loginResult) {
                $vals = array_map(fn($v) => (string)$v->toString(), $loginResult);
                $q->whereIn('login_result', $vals);
            })
            ->when(!empty($failureCodes), function ($q) use ($failureCodes) {
                $vals = array_map(fn($v) => (string)$v->toString(), $failureCodes);
                $q->whereIn('failure_reason_code', $vals);
            })
            ->when($from !== null, function ($q) use ($from) {
                $q->where('logged_in_at', '>=', Carbon::parse($from));
            })
            ->when($to !== null, function ($q) use ($to) {
                $q->where('logged_in_at', '<=', Carbon::parse($to));
            })
            ->when($keyword !== null, function ($q) use ($keyword) {
                $q->where(function ($qq) use ($keyword) {
                    $qq->where('login_id', 'like', $keyword)
                       ->orWhere('ip_address', 'like', $keyword)
                       ->orWhere('user_agent', 'like', $keyword);
                });
            })
        ;

        $models = $query->orderBy('logged_in_at', 'desc')->get();

        return $models->map(fn($m) => Mapper::mapModelToDomain($m))->toArray();
    }
}
