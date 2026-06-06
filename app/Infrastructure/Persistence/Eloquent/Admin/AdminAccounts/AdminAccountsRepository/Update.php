<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccounts\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Domain\Shared\Enum as SEnum;
use App\Models\Admin\AdminAccount;
use App\Models\Admin\AdminAccountHistory;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;

final class Update
{
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // 処理なし
    }

    public function run(DomainEntity $entity): DomainEntity
    {
        $adminAccount = AdminAccount::query()
            ->where('id', $entity->id()->toString())
            ->lockForUpdate()
            ->firstOrFail();

        $adminAccount->update(array_filter([
            'email' => $entity->email()->toStringOrNull(),
            'password' => $entity->password()->toStringOrNull() 
                ? Hash::make($entity->password()->toStringOrNull()) 
                : null,
            'name' => $entity->name()->toStringOrNull(),
            'admin_note' => $entity->adminNote()->toStringOrNull(),
            'account_status_master_id' => $entity->accountStatusMasterId()->toStringOrNull(),
            'is_email_verified' => $entity->isEmailVerified()->toIntOrNull() ?? null,
            'password_changed_at' => $entity->passwordChangedAt()?->format('Y-m-d\\TH:i:s') ?? null,
            'password_expires_at' => $entity->passwordExpiresAt()?->format('Y-m-d\\TH:i:s') ?? null,
            'modified_at' => $entity->modifiedAt()?->format('Y-m-d\\TH:i:s') ?? null,
            'modified_by' => $entity->modifiedBy()?->toStringOrNull(),
            'modified_ip' => $entity->modifiedIp()?->toStringOrNull(),
        ], fn($v) => $v !== null));

        AdminAccountHistory::create([
            'id' => Uuid::uuid7()->toString(),
            'admin_account_id' => $adminAccount->id,
            'email' => $adminAccount->email,
            'password' => $adminAccount->password,
            'name' => $adminAccount->name,
            'admin_note' => $adminAccount->admin_note,
            'account_status_master_id' => $adminAccount->account_status_master_id,
            'is_email_verified' => $adminAccount->is_email_verified,
            'password_changed_at' => $adminAccount->password_changed_at,
            'password_expires_at' => $adminAccount->password_expires_at,
            'created_at' => $adminAccount->created_at,
            'created_by' => $adminAccount->created_by,
            'created_ip' => $adminAccount->created_ip,
            'modified_at' => $adminAccount->modified_at,
            'modified_by' => $adminAccount->modified_by,
            'modified_ip' => $adminAccount->modified_ip,
            'operation_type' => SEnum\OperationType::UPDATE,
            'history_created' => $this->datetime->format('Y-m-d\\TH:i:s'),
        ]);

        return (new Read($this->datetime))->run($entity->id());
    }
}
