<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\LoginLogs;

use App\Domain\Log\LoginLogs\Entity\LoginLog as DomainEntity;
use App\Domain\Log\LoginLogs\Repository\LoginLogsRepository as DomainRepository;
use App\Domain\Log\LoginLogs\SearchCondition;
use App\Domain\Log\LoginLogs\ValueObject as Vo;
use App\Models\Log\LoginLog as EloquentModel;
use Illuminate\Support\Carbon;

final class LoginLogsRepository implements DomainRepository
{
    public function search(SearchCondition $condition): array
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

    public function create(DomainEntity $entity): DomainEntity
    {
        $data = [
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
        ];

        $model = EloquentModel::create($data);

        return Mapper::mapModelToDomain($model);
    }

    public function read(Vo\Id $id): DomainEntity
    {
        $m = EloquentModel::query()->findOrFail($id->toString());

        return Mapper::mapModelToDomain($m);
    }

    public function checkFailureLoginLimit(Vo\LoginId $loginId): bool
    {
        // Simple policy: allow if failures in last 15 minutes < 5
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
