<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\User\UserAccounts\UserAccountsRepository;

use App\Domain\User\UserAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as Svo;
use App\Domain\User\UserAccounts\Entity\UserAccount as DomainEntity;
use App\Models\User\UserAccount;

final class Read
{
    public function __construct(private readonly \DateTimeInterface $datetime)
    {
        // no-op
    }

    public function run(Vo\Id $id, ?Svo\ModifiedAt $modifiedAt = null): DomainEntity
    {
        $userAccountModel = UserAccount::query()
            ->join(
                'account_status_masters', 
                'account_status_masters.id', 
                '=', 
                'user_accounts.account_status_master_id'
            )
            ->select(
                'user_accounts.id',
                'user_accounts.email',
                'user_accounts.password',
                'user_accounts.name',
                'user_accounts.account_status_master_id',
                'account_status_masters.code as account_status_master_code',
                'account_status_masters.name as account_status_master_name',
                'user_accounts.is_email_verified',
                'user_accounts.password_changed_at',
                'user_accounts.password_expires_at',
                'user_accounts.created_at',
                'user_accounts.created_by',
                'user_accounts.created_ip',
                'user_accounts.modified_at',
                'user_accounts.modified_by',
                'user_accounts.modified_ip',
            )
            ->where('user_accounts.id', $id->toString())
            ->where(function ($query) use ($modifiedAt) {
                if ($modifiedAt !== null) {
                    $query->where('user_accounts.modified_at', $modifiedAt->toString());
                }
            })
            ->firstOrFail();

        return Mapper::mapModelToDomain($userAccountModel);
    }
}
