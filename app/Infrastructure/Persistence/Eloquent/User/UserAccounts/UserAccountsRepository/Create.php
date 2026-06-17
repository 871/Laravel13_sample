<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\User\UserAccounts\UserAccountsRepository;

use App\Domain\User\UserAccounts\Entity\UserAccount as DomainEntity;
use App\Domain\User\UserAccounts\ValueObject as Vo;
use App\Domain\Shared\Enum as SEnum;
use App\Models\User\UserAccount;
use App\Models\User\UserAccountHistory;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;

final class Create
{
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // no-op
    }

    public function run(DomainEntity $entity): DomainEntity
    {
        $userAccount = UserAccount::create([
            'email' => $entity->email()->toString(),
            'password' => Hash::make($entity->password()->toString()),
            'name' => $entity->name()->toString(),
            'account_status_master_id' => $entity->accountStatusMasterId()->toString(),
            'is_email_verified' => $entity->isEmailVerified()->toIntOrNull() ?? 0,
            'password_changed_at' => $entity->passwordChangedAt()?->format('Y-m-d\\TH:i:s') ?? null,
            'password_expires_at' => $entity->passwordExpiresAt()?->format('Y-m-d\\TH:i:s') ?? null,
            'created_at' => $entity->createdAt()?->format('Y-m-d\\TH:i:s') ?? null,
            'created_by' => $entity->createdBy()->toIntOrNull(),
            'created_ip' => $entity->createdIp()->toStringOrNull(),
            'modified_at' => $entity->modifiedAt()?->format('Y-m-d\\TH:i:s') ?? null,
            'modified_by' => $entity->modifiedBy()->toIntOrNull(),
            'modified_ip' => $entity->modifiedIp()->toStringOrNull(),
        ]);

        $h = UserAccountHistory::create([
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
            'operation_type' => SEnum\OperationType::INSERT,
            'history_created' => $this->datetime->format('Y-m-d\\TH:i:s'),
        ]);

        return (new Read($this->datetime))->run(Vo\Id::fromString((string)$userAccount->id));
    }
}
