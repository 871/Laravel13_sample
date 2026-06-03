<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\ValueObject as Vo;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccountHistory as DomainHistoryEntity;
use App\Models\Admin\AdminAccountHistory as EloquentHistory;

final class ReadHistories
{
    public function __construct(private readonly Vo\Id $adminAccountId)
    {
    }

    /**
     * @return array<DomainHistoryEntity>
     */
    public function run(): array
    {
        $models = EloquentHistory::with('accountStatusMaster')
            ->where('admin_account_id', $this->adminAccountId->toString())
            ->orderBy('history_created', 'desc')
            ->get();

        $results = [];
        foreach ($models as $m) {
            $results[] = Mapper::mapHistoryModelToDomain($m);
        }

        return $results;
    }
}
