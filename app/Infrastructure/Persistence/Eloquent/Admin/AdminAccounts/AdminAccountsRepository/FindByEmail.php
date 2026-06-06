<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Models\Admin\AdminAccount;

final class FindByEmail
{
    public function __construct(private readonly \DateTimeInterface $datetime)
    {
        // 処理なし
    }

    public function run(Vo\Email $email): ?DomainEntity
    {
        $adminAccount = AdminAccount::query()
            ->join(
                'account_status_masters', 
                'account_status_masters.id', 
                '=', 
                'admin_accounts.account_status_master_id'
            )
            ->select(
                'admin_accounts.id',
                'admin_accounts.email',
                'admin_accounts.password',
                'admin_accounts.name',
                'admin_accounts.admin_note',
                'admin_accounts.account_status_master_id',
                'account_status_masters.code as account_status_master_code',
                'account_status_masters.name as account_status_master_name',
                'admin_accounts.is_email_verified',
                'admin_accounts.password_changed_at',
                'admin_accounts.password_expires_at',
                'admin_accounts.created_at',
                'admin_accounts.created_by',
                'admin_accounts.created_ip',
                'admin_accounts.modified_at',
                'admin_accounts.modified_by',
                'admin_accounts.modified_ip',
            )
            ->where('admin_accounts.email', $email->toString())
            ->first();

        return $adminAccount === null ? null : Mapper::mapModelToDomain($adminAccount);
    }
}
