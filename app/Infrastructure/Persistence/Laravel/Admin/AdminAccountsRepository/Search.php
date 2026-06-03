<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Laravel\Admin\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\SearchCondition;
use App\Models\Admin\AdminAccount as EloquentModel;

final class Search
{
    public function __construct(private readonly SearchCondition $condition)
    {
    }

    /**
     * @return array
     */
    public function run(): array
    {
        $query = EloquentModel::query()->with('accountStatusMaster');

        $id = $this->condition->getId()->toStringOrNull();
        if ($id !== null && $id !== '') {
            $query->where('id', $id);
        }

        $statusId = $this->condition->getAccountStatusMasterId()->toStringOrNull();
        if ($statusId !== null && $statusId !== '') {
            $query->where('account_status_master_id', $statusId);
        }

        $keyword = $this->condition->getKeyword()->toQueryLikeOrNull();
        if ($keyword !== null && $keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('email', 'like', $keyword)
                  ->orWhere('name', 'like', $keyword);
            });
        }

        $models = $query->get();

        $results = [];
        foreach ($models as $model) {
            $results[] = Mapper::mapModelToDomain($model);
        }

        return $results;
    }
}
