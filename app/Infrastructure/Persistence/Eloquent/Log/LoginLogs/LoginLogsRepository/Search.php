<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\LoginLogs\LoginLogsRepository;

use App\Domain\Log\LoginLogs\SearchCondition;
use App\Models\Log\LoginLog;
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
        $loginLog = LoginLog::query()
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
            // Memo: 利用想定INDEX
            // KEY `login_logs_idx02` (`account_id`,`logged_in_at`),
            // KEY `login_logs_idx03` (`impersonator_account_id`,`logged_in_at`),
            // KEY `login_logs_idx01` (`logged_in_at`,`login_id`,`login_result`),
            ->when(filled($condition->getAccountId()->toStringOrNull()), function ($q) use ($condition) {
                $q->where(
                    'login_logs.account_id', 
                    $condition->getAccountId()->toStringOrNull()
                );
            })
            ->when(filled($condition->getImpersonatorAccountId()->toStringOrNull()), function ($q) use ($condition) {
                $q->where(
                    'login_logs.impersonator_account_id', 
                    $condition->getImpersonatorAccountId()->toStringOrNull()
                );
            })
            ->when(filled($condition->getLoggedInAtFrom()->toDateTimeOrNull()), function ($q) use ($condition) {
                $q->where(
                    'login_logs.logged_in_at', 
                    '>=', 
                    Carbon::parse($condition->getLoggedInAtFrom()->toDateTimeOrNull())
                );
            })
            ->when(filled($condition->getLoggedInAtTo()->toDateTimeOrNull()), function ($q) use ($condition) {
                $q->where(
                    'login_logs.logged_in_at', 
                    '<=', 
                    Carbon::parse($condition->getLoggedInAtTo()->toDateTimeOrNull())
                );
            })
            ->when(filled($condition->getLoginActorType()), function ($q) use ($condition) {
                $q->whereIn(
                    'login_logs.login_actor_type', 
                    array_map(
                        fn($t) => (string)$t->toString(), 
                        $condition->getLoginActorType()
                    )
                );
            })
            ->when(filled($condition->getLoginResult()), function ($q) use ($condition) {
                $q->whereIn(
                    'login_logs.login_result', 
                    array_map(
                        fn($v) => (string)$v->toString(), 
                        $condition->getLoginResult()
                    )
                );
            })
            ->when(filled($condition->getFailureReasonCode()), function ($q) use ($condition) {
                $q->whereIn(
                    'login_logs.failure_reason_code',
                    array_map(
                        fn($v) => (string)$v->toString(),
                        $condition->getFailureReasonCode()
                    )
                );
            })
            ->when(filled($condition->getKeyword()->toQueryLikeOrNull()), function ($q) use ($condition) {
                $keyword = $condition->getKeyword()->toQueryLikeOrNull();
                $q->where(function ($qq) use ($keyword) {
                    $qq->where('login_logs.login_id', 'LIKE', $keyword)
                       ->orWhere('login_logs.ip_address', 'LIKE', $keyword)
                       ->orWhere('login_logs.user_agent', 'LIKE', $keyword);
                });
            })
            ->orderBy(
                $condition->getOrderBy()->getColumn(), 
                $condition->getOrderBy()->getOrder(),
            )
            ->orderBy('login_logs.id', 'DESC')
            ;

        $paginator = $loginLog->paginate(
            perPage: $condition->getPerPage(),
            page: $condition->getPage(),
        );

        $collection = $paginator->getCollection()->map(fn ($model) => Mapper::mapModelToDomain($model));

        // Return plain array of domain entities (not paginator metadata) to match repository contract
        return $collection->all();
    }
}
