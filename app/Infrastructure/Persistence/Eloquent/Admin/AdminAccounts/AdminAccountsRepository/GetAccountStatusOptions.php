<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccounts\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Admin\AdminAccounts\Entity\AccountStatusMaster as DomainEntity;
use App\Models\Shared\AccountStatusMaster;

final class GetAccountStatusOptions
{
    public function __construct(private readonly \DateTimeInterface $datetime)
    {
        // 処理なし
    }

    public function run(): array
    {
        return AccountStatusMaster::query()
            ->select('id', 'code', 'name')
            ->get()
            ->map(fn (AccountStatusMaster $master) => new DomainEntity(
                account_status_master_id: new Vo\AccountStatusMasterId((string)$master->id),
                account_status_master_code: new Vo\AccountStatusMasterCode($master->code),
                account_status_master_name: new Vo\AccountStatusMasterName($master->name)
            ))
            ->toArray();
    }
}
