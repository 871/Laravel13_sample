<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\ValueObject as Vo;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccountHistory as DomainHistoryEntity;
use App\Models\Admin\AdminAccountHistory;

final class ReadHistories
{
    public function __construct(private readonly \DateTimeInterface $datetime)
    {
        // 処理なし
    }

    /**
     * @return array<DomainHistoryEntity>
     */
    public function run(Vo\Id $id): array
    {
        return AdminAccountHistory::query()
            ->join(
                'account_status_masters', 
                'account_status_masters.id', 
                '=', 
                'admin_account_histories.account_status_master_id'
            )
            ->select(
                'admin_account_histories.id',
                'admin_account_histories.admin_account_id',
                'admin_account_histories.email',
                'admin_account_histories.name',
                'admin_account_histories.admin_note',
                'admin_account_histories.account_status_master_id',
                'account_status_masters.code as account_status_master_code',
                'account_status_masters.name as account_status_master_name',
                'admin_account_histories.is_email_verified',
                'admin_account_histories.password_changed_at',
                'admin_account_histories.password_expires_at',
                'admin_account_histories.created_at',
                'admin_account_histories.created_by',
                'admin_account_histories.created_ip',
                'admin_account_histories.modified_at',
                'admin_account_histories.modified_by',
                'admin_account_histories.modified_ip',
                'admin_account_histories.operation_type',
                'admin_account_histories.history_created',
            )
            ->where([
                'admin_account_histories.admin_account_id' => $id->toStringOrNull(),
            ])
            ->orderBy('admin_account_histories.history_created', 'DESC')
            ->get()
            ->map(fn (AdminAccountHistory $h) => Mapper::mapHistoryModelToDomain($h))
            ->toArray() ?? [];
    }
}
