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
        $query = EloquentModel::query()
            ->when(!empty($condition->getLoginActorType()), function ($q) use ($condition) {
                $typeValues = array_map(fn($t) => (string)$t->toString(), $condition->getLoginActorType());
                $q->whereIn('login_actor_type', $typeValues);
            })
            ->when($condition->getAccountId()->toStringOrNull() !== null, function ($q) use ($condition) {
                $q->where('account_id', $condition->getAccountId()->toStringOrNull());
            })
            ->when($condition->getImpersonatorAccountId()->toStringOrNull() !== null, function ($q) use ($condition) {
                $q->where('impersonator_account_id', $condition->getImpersonatorAccountId()->toStringOrNull());
            })
            ->when(!empty($condition->getLoginResult()), function ($q) use ($condition) {
                $vals = array_map(fn($v) => (string)$v->toString(), $condition->getLoginResult());
                $q->whereIn('login_result', $vals);
            })
            ->when(!empty($condition->getFailureReasonCode()), function ($q) use ($condition) {
                $vals = array_map(fn($v) => (string)$v->toString(), $condition->getFailureReasonCode());
                $q->whereIn('failure_reason_code', $vals);
            })
            ->when($condition->getLoggedInAtFrom()->toDateTimeOrNull() !== null, function ($q) use ($condition) {
                $q->where('logged_in_at', '>=', Carbon::parse($condition->getLoggedInAtFrom()->toDateTimeOrNull()));
            })
            ->when($condition->getLoggedInAtTo()->toDateTimeOrNull() !== null, function ($q) use ($condition) {
                $q->where('logged_in_at', '<=', Carbon::parse($condition->getLoggedInAtTo()->toDateTimeOrNull()));
            })
            ->when($condition->getKeyword()->toQueryLikeOrNull() !== null, function ($q) use ($condition) {
                $keyword = $condition->getKeyword()->toQueryLikeOrNull();
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
