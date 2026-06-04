<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Domain\Shared\Enum as SEnum;
use App\Models\Admin\AdminAccount as MainModel;
use App\Models\Admin\AdminAccountHistory as HistoryModel;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;

final class Create
{
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // 処理なし
    }

    public function run(DomainEntity $entity): DomainEntity
    {
        $mainModel = MainModel::create([
            'email' => $entity->email()->toString(),
            'password' => Hash::make($entity->password()->toString()),
            'name' => $entity->name()->toString(),
            'admin_note' => $entity->adminNote()->toString(),
            'account_status_master_id' => $entity->accountStatusMasterId()->toString(),
            'is_email_verified' => $entity->isEmailVerified()->toIntOrNull() ?? 0,
            'password_changed_at' => $entity->passwordChangedAt()?->toString() ?? null,
            'password_expires_at' => $entity->passwordExpiresAt()?->toString() ?? null,
            'created_at' => $entity->createdAt()?->format('Y-m-d\\TH:i:s') ?? null,
            'created_by' => $entity->createdBy()?->toString(), 
            'created_ip' => $entity->createdIp()?->toString(),
            'modified_at' => $entity->modifiedAt()?->format('Y-m-d\\TH:i:s') ?? null,
            'modified_by' => $entity->modifiedBy()?->toString(),
            'modified_ip' => $entity->modifiedIp()?->toString(),
        ]);

        HistoryModel::create([
            'id' => Uuid::uuid7()->toString(),
            'admin_account_id' => $mainModel->id,
            'email' => $mainModel->email,
            'password' => $mainModel->password,
            'name' => $mainModel->name,
            'admin_note' => $mainModel->admin_note,
            'account_status_master_id' => $mainModel->account_status_master_id,
            'is_email_verified' => $mainModel->is_email_verified,
            'password_changed_at' => $mainModel->password_changed_at,
            'password_expires_at' => $mainModel->password_expires_at,
            'created_at' => $mainModel->created_at,
            'created_by' => $mainModel->created_by,
            'created_ip' => $mainModel->created_ip,
            'modified_at' => $mainModel->modified_at,
            'modified_by' => $mainModel->modified_by,
            'modified_ip' => $mainModel->modified_ip,
            'operation_type' => SEnum\OperationType::INSERT,
            'history_created' => $this->datetime->format('Y-m-d\\TH:i:s'),
        ]);

        return (new Read($this->datetime))->run($entity->id());
    }
}
