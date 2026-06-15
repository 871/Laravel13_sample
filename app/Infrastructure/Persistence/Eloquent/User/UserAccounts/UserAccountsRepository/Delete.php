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

final class Delete
{
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // no-op
    }

    public function run(Vo\Id $id): DomainEntity
    {
        $userAccount = (new Read($this->datetime))->run($id);

        UserAccount::destroy($id->toString());
        
        UserAccountHistory::create([
            'id' => Uuid::uuid7()->toString(),
            'user_account_id' => $userAccount->id()->toString(),
            'email' => $userAccount->email()->toString(),
            'password' => $userAccount->password()->toString(),
            'name' => $userAccount->name()->toString(),
            'account_status_master_id' => $userAccount->accountStatusMasterId()->toString(),
            'is_email_verified' => $userAccount->isEmailVerified() ? '1' : '0',
            'password_changed_at' => $userAccount->passwordChangedAt()->toString(),
            'password_expires_at' => $userAccount->passwordExpiresAt()->toString(),
            'created_at' => $userAccount->createdAt()->toString(),
            'created_by' => $userAccount->createdBy()->toString(),
            'created_ip' => $userAccount->createdIp()->toString(),
            'modified_at' => $userAccount->modifiedAt()->toString(),
            'modified_by' => $userAccount->modifiedBy()->toString(),
            'modified_ip' => $userAccount->modifiedIp()->toString(),
            'operation_type' => SEnum\OperationType::DELETE,
            'history_created' => $this->datetime->format('Y-m-d\\TH:i:s'),
        ]);

        return $userAccount;
    }
}
