<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\User\UserAccounts\UserAccountsRepository;

use App\Domain\User\UserAccounts\Entity\UserAccount as DomainEntity;
use App\Domain\Shared\Enum as SEnum;
use App\Models\User\UserAccount;
use App\Models\User\UserAccountHistory;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;

final class Update
{
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // no-op
    }

    public function run(DomainEntity $entity): DomainEntity
    {
        $userAccount = UserAccount::query()
            ->where('id', $entity->id()->toString())
            ->lockForUpdate()
            ->firstOrFail();

        $userAccount->update(array_filter([
            'email' => $entity->email()->toStringOrNull(),
            'password' => $entity->password()->toStringOrNull()
                ? Hash::make($entity->password()->toStringOrNull())
                : null,
            'name' => $entity->name()->toStringOrNull(),
            'account_status_master_id' => $entity->accountStatusMasterId()->toStringOrNull(),
            'is_email_verified' => $entity->isEmailVerified()->toIntOrNull() ?? null,
            'password_changed_at' => $entity->passwordChangedAt()?->format('Y-m-d\\TH:i:s') ?? null,
            'password_expires_at' => $entity->passwordExpiresAt()?->format('Y-m-d\\TH:i:s') ?? null,
            'modified_at' => $entity->modifiedAt()?->format('Y-m-d\\TH:i:s') ?? null,
            'modified_by' => $entity->modifiedBy()?->toStringOrNull(),
            'modified_ip' => $entity->modifiedIp()?->toStringOrNull(),
        ], fn($v) => $v !== null));

        UserAccountHistory::create([
            'id' => Uuid::uuid7()->toString(),
            'user_account_id' => $userAccount->id,
            'email' => $userAccount->email,
            'password' => $userAccount->password,
            'name' => $userAccount->name,
            'account_status_master_id' => $userAccount->account_status_master_id,
            'is_email_verified' => $userAccount->is_email_verified,
            'password_changed_at' => $userAccount->password_changed_at,
            'password_expires_at' => $userAccount->password_expires_at,
            'created_at' => $userAccount->created_at,
            'created_by' => $userAccount->created_by,
            'created_ip' => $userAccount->created_ip,
            'modified_at' => $userAccount->modified_at,
            'modified_by' => $userAccount->modified_by,
            'modified_ip' => $userAccount->modified_ip,
            'operation_type' => SEnum\OperationType::UPDATE,
            'history_created' => $this->datetime->format('Y-m-d\\TH:i:s'),
        ]);

        return (new Read($this->datetime))->run($entity->id());
    }
}
