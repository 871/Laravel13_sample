<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\User\UserAccounts\UserAccountsRepository;

use App\Domain\User\UserAccounts\Entity\UserAccount as DomainEntity;
use App\Domain\User\UserAccounts\Entity\UserAccountHistory as DomainHistoryEntity;
use App\Domain\User\UserAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use App\Models\User\UserAccount as EloquentModel;
use App\Models\User\UserAccountHistory as EloquentHistory;

final class Mapper
{
    public static function mapModelToDomain(EloquentModel $m): DomainEntity
    {
        return new DomainEntity(
            new Vo\Id((string)$m->id),
            new Vo\Email((string)$m->email),
            new Vo\Password((string)$m->password),
            new Vo\Name((string)$m->name),
            new Vo\AccountStatusMasterId((string)($m->account_status_master_id ?? null)),
            new Vo\AccountStatusMasterCode($m->account_status_master_code ?? null),
            new Vo\AccountStatusMasterName($m->account_status_master_name ?? null),
            new Vo\IsEmailVerified((string)($m->is_email_verified ? '1' : '0')),
            new Vo\PasswordChangedAt($m->password_changed_at?->format('Y-m-d\\TH:i:s') ?? null),
            new Vo\PasswordExpiresAt($m->password_expires_at?->format('Y-m-d\\TH:i:s') ?? null),
            new SVo\CreatedAt($m->created_at?->format('Y-m-d\\TH:i:s') ?? null),
            new SVo\CreatedBy((string)$m->created_by ?? null),
            new SVo\CreatedIp($m->created_ip ?? null),
            new SVo\ModifiedAt($m->modified_at?->format('Y-m-d\\TH:i:s') ?? null),
            new SVo\ModifiedBy((string)$m->modified_by ?? null),
            new SVo\ModifiedIp($m->modified_ip ?? null),
        );
    }

    public static function mapHistoryModelToDomain(EloquentHistory $h): DomainHistoryEntity
    {
        return new DomainHistoryEntity(
            new SVo\Uuid((string)$h->id),
            new Vo\Id((string)$h->user_account_id),
            new Vo\Email((string)$h->email),
            new Vo\Password((string)$h->password),
            new Vo\Name((string)$h->name),
            new Vo\AccountStatusMasterId((string)($h->account_status_master_id ?? null)),
            new Vo\AccountStatusMasterCode($h->account_status_master_code ?? null),
            new Vo\AccountStatusMasterName($h->account_status_master_name ?? null),
            new Vo\IsEmailVerified((string)($h->is_email_verified ? '1' : '0')),
            new Vo\PasswordChangedAt($h->password_changed_at?->format('Y-m-d\\TH:i:s') ?? null),
            new Vo\PasswordExpiresAt($h->password_expires_at?->format('Y-m-d\\TH:i:s') ?? null),
            new SVo\CreatedAt($h->created_at?->format('Y-m-d\\TH:i:s') ?? null),
            new SVo\CreatedBy((string)$h->created_by ?? null),
            new SVo\CreatedIp($h->created_ip ?? null),
            new SVo\ModifiedAt($h->modified_at?->format('Y-m-d\\TH:i:s') ?? null),
            new SVo\ModifiedBy((string)$h->modified_by ?? null),
            new SVo\ModifiedIp($h->modified_ip ?? null),
            new SVo\OperationType($h->operation_type ?? null),
            new SVo\HistoryCreated($h->history_created?->format('Y-m-d\\TH:i:s') ?? null),
        );
    }
}
