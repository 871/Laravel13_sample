<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\PageAccessLogs\PageAccessLogsRepository;

use App\Domain\Log\PageAccessLogs\Entity\PageAccessLog as DomainEntity;
use App\Domain\Log\PageAccessLogs\SearchCondition;
use App\Domain\Log\PageAccessLogs\ValueObject\Search\NavigationType;
use App\Infrastructure\Persistence\Eloquent\Log\PageAccessLogs\PageAccessLogsRepository\Mapper;
use App\Models\Log\PageAccessLog as EloquentModel;

final class Search
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(private readonly \DateTimeInterface $datetime)
    {
        // no-op
    }

    /**
     * @param \App\Domain\Log\PageAccessLogs\SearchCondition $condition
     * @return array<\App\Domain\Log\PageAccessLogs\Entity\PageAccessLog>
     */
    public function run(SearchCondition $condition): array
    {
        return match ($condition->getNavigationType()->toString()) {
            NavigationType::FIRST => $this->searchFirst($condition),
            NavigationType::LAST => $this->searchLast($condition),
            NavigationType::NEXT => $this->searchNext($condition),
            NavigationType::PREV => $this->searchPrev($condition),
            default => throw new \LogicException('Unknown navigation type: ' . $condition->getNavigationType()->toString()),
        };
    }

    /**
     * @return array<\App\Domain\Log\PageAccessLogs\Entity\PageAccessLog>
     */
    private function searchFirst(SearchCondition $condition): array
    {
        $q = EloquentModel::query()->leftJoin('admin_accounts', function ($join) {
            $join->on('admin_accounts.id', '=', 'page_access_logs.account_id')
                 ->where('page_access_logs.account_type', 'ADMIN');
        })->select('page_access_logs.*');

        $this->applyCommonWhere($q, $condition);

        $orm = $q->orderBy('page_access_logs.accessed', 'asc')
            ->orderBy('page_access_logs.account_id', 'asc')
            ->limit($condition->getLimit())
            ->get();

        return $orm->map(fn($m) => Mapper::mapModelToDomain($m))->toArray();
    }

    /**
     * @return array<\App\Domain\Log\PageAccessLogs\Entity\PageAccessLog>
     */
    private function searchLast(SearchCondition $condition): array
    {
        $q = EloquentModel::query()->leftJoin('admin_accounts', function ($join) {
            $join->on('admin_accounts.id', '=', 'page_access_logs.account_id')
                 ->where('page_access_logs.account_type', 'ADMIN');
        })->select('page_access_logs.*');

        $this->applyCommonWhere($q, $condition);

        $orm = $q->orderBy('page_access_logs.accessed', 'desc')
            ->orderBy('page_access_logs.account_id', 'desc')
            ->limit($condition->getLimit())
            ->get();

        $arr = $orm->map(fn($m) => Mapper::mapModelToDomain($m))->toArray();

        return array_reverse($arr);
    }

    /**
     * @return array<\App\Domain\Log\PageAccessLogs\Entity\PageAccessLog>
     */
    private function searchNext(SearchCondition $condition): array
    {
        $q = EloquentModel::query()->leftJoin('admin_accounts', function ($join) {
            $join->on('admin_accounts.id', '=', 'page_access_logs.account_id')
                 ->where('page_access_logs.account_type', 'ADMIN');
        })->select('page_access_logs.*');

        $q->where('page_access_logs.search_key', '>', $condition->getSearchKey()->toString());

        $this->applyCommonWhere($q, $condition);

        $orm = $q->orderBy('page_access_logs.accessed', 'asc')
            ->orderBy('page_access_logs.account_id', 'asc')
            ->limit($condition->getLimit())
            ->get();

        return $orm->map(fn($m) => Mapper::mapModelToDomain($m))->toArray();
    }

    /**
     * @return array<\App\Domain\Log\PageAccessLogs\Entity\PageAccessLog>
     */
    private function searchPrev(SearchCondition $condition): array
    {
        $q = EloquentModel::query()->leftJoin('admin_accounts', function ($join) {
            $join->on('admin_accounts.id', '=', 'page_access_logs.account_id')
                 ->where('page_access_logs.account_type', 'ADMIN');
        })->select('page_access_logs.*');

        $q->where('page_access_logs.search_key', '<', $condition->getSearchKey()->toString());

        $this->applyCommonWhere($q, $condition);

        $orm = $q->orderBy('page_access_logs.accessed', 'desc')
            ->orderBy('page_access_logs.account_id', 'desc')
            ->limit($condition->getLimit())
            ->get();

        $arr = $orm->map(fn($m) => Mapper::mapModelToDomain($m))->toArray();

        return array_reverse($arr);
    }

    private function applyCommonWhere($q, SearchCondition $condition): void
    {
        $from = $condition->getAccessedFrom()->format('Y-m-d\\TH:i:s');
        $to = $condition->getAccessedTo()->format('Y-m-d\\TH:i:s');

        $q->whereBetween('page_access_logs.accessed', [$from, $to]);

        $accountType = $condition->getAccountType()->toStringOrNull();
        if ($accountType !== null && $accountType !== '') {
            $q->where('page_access_logs.account_type', $accountType);
        }

        $accountId = $condition->getAccountId()->toStringOrNull();
        if ($accountId !== null && $accountId !== '') {
            $q->where('page_access_logs.account_id', $accountId);
        }

        // Keyword OR conditions
        $likes = $condition->getKeyword()->toQueryLikeList();
        if (!empty($likes)) {
            $q->where(function ($sub) use ($likes) {
                foreach ($likes as $like) {
                    $sub->orWhere(function ($inner) use ($like) {
                        $inner->orWhere('page_access_logs.path', 'like', $like)
                              ->orWhere('page_access_logs.route_name', 'like', $like)
                              ->orWhere('page_access_logs.ip_address', 'like', $like)
                              ->orWhere('page_access_logs.user_agent', 'like', $like)
                              ->orWhere('admin_accounts.name', 'like', $like);
                    });
                }
            });
        }
    }
}
