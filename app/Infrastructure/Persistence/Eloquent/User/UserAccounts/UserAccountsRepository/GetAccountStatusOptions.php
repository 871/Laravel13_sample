<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\User\UserAccounts\UserAccountsRepository;

use App\Domain\User\UserAccounts\ValueObject as Vo;
use App\Domain\User\UserAccounts\Entity\AccountStatusMaster as DomainEntity;
use App\Models\Shared\AccountStatusMaster;

final class GetAccountStatusOptions
{
    public function __construct(private readonly \DateTimeInterface $datetime)
    {
        // no-op
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
