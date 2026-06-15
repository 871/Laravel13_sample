<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\User\UserAccounts\UserAccountsRepository;

use App\Domain\User\UserAccounts\ValueObject as Vo;

use App\Domain\User\UserAccounts\Entity\UserAccountHistory as DomainHistoryEntity;
use App\Models\User\UserAccountHistory;

final class ReadHistories
{
    public function __construct(private readonly \DateTimeInterface $datetime)
    {
        // no-op
    }

    /**
     * @return array<DomainHistoryEntity>
     */
    public function run(Vo\Id $id): array
    {
        return UserAccountHistory::query()
            ->join(
                'account_status_masters', 
                'account_status_masters.id', 
                '=', 
                'user_account_histories.account_status_master_id'
            )
            ->select(
                'user_account_histories.id',
                'user_account_histories.user_account_id',
                'user_account_histories.email',
                'user_account_histories.name',
                'user_account_histories.account_status_master_id',
                'account_status_masters.code as account_status_master_code',
                'account_status_masters.name as account_status_master_name',
                'user_account_histories.is_email_verified',
                'user_account_histories.password_changed_at',
                'user_account_histories.password_expires_at',
                'user_account_histories.created_at',
                'user_account_histories.created_by',
                'user_account_histories.created_ip',
                'user_account_histories.modified_at',
                'user_account_histories.modified_by',
                'user_account_histories.modified_ip',
                'user_account_histories.operation_type',
                'user_account_histories.history_created',
            )
            ->where([
                'user_account_histories.user_account_id' => $id->toStringOrNull(),
            ])
            ->orderBy('user_account_histories.history_created', 'DESC')
            ->get()
            ->map(fn (UserAccountHistory $h) => Mapper::mapHistoryModelToDomain($h))
            ->toArray() ?? [];
    }
}
