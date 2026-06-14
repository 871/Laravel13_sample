<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccounts\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Shared\Enum as SEnum;
use App\Models\Admin\AdminAccount;
use App\Models\Admin\AdminAccountHistory;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;

final class Delete
{
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // 処理なし
    }

    public function run(Vo\Id $id): DomainEntity
    {
        $adminAccount = (new Read($this->datetime))->run($id);

        AdminAccount::destroy($id->toString());
        
        AdminAccountHistory::create([
            'id' => Uuid::uuid7()->toString(),
            'admin_account_id' => $adminAccount->id()->toString(),
            'email' => $adminAccount->email()->toString(),
            'password' => $adminAccount->password()->toString(),
            'name' => $adminAccount->name()->toString(),
            'admin_note' => $adminAccount->adminNote()->toString(),
            'account_status_master_id' => $adminAccount->accountStatusMasterId()->toString(),
            'is_email_verified' => $adminAccount->isEmailVerified() ? '1' : '0',
            'password_changed_at' => $adminAccount->passwordChangedAt()->toString(),
            'password_expires_at' => $adminAccount->passwordExpiresAt()->toString(),
            'created_at' => $adminAccount->createdAt()->toString(),
            'created_by' => $adminAccount->createdBy()->toString(),
            'created_ip' => $adminAccount->createdIp()->toString(),
            'modified_at' => $adminAccount->modifiedAt()->toString(),
            'modified_by' => $adminAccount->modifiedBy()->toString(),
            'modified_ip' => $adminAccount->modifiedIp()->toString(),
            'operation_type' => SEnum\OperationType::DELETE,
            'history_created' => $this->datetime->format('Y-m-d\\TH:i:s'),
        ]);

        return $adminAccount;
    }
}
