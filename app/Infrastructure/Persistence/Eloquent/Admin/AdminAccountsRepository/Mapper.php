<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Domain\Admin\AdminAccounts\Entity\AdminAccountHistory as DomainHistoryEntity;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use App\Models\Admin\AdminAccount as EloquentModel;
use App\Models\Admin\AdminAccountHistory as EloquentHistory;

final class Mapper
{
    public static function mapModelToDomain(EloquentModel $m): DomainEntity
    {
        $accountStatus = $m->accountStatusMaster;

        return new DomainEntity(
            new Vo\Id((string)$m->id),
            new Vo\Email((string)$m->email),
            new Vo\Password((string)$m->password),
            new Vo\Name((string)$m->name),
            new Vo\AdminNote((string)$m->admin_note),
            new Vo\AccountStatusMasterId((string)($m->account_status_master_id ?? null)),
            new Vo\AccountStatusMasterCode($accountStatus?->code ?? null),
            new Vo\AccountStatusMasterName($accountStatus?->name ?? null),
            new Vo\IsEmailVerified((string)($m->is_email_verified ? '1' : '0')),
            new Vo\PasswordChangedAt($m->password_changed_at?->format('Y-m-d\\TH:i:s') ?? null),
            new Vo\PasswordExpiresAt($m->password_expires_at?->format('Y-m-d\\TH:i:s') ?? null),
            new SVo\Created($m->created?->format('Y-m-d\\TH:i:s') ?? null),
            new SVo\CreatedBy($m->created_by ?? null),
            new SVo\CreatedIp($m->created_ip ?? null),
            new SVo\Modified($m->modified?->format('Y-m-d\\TH:i:s') ?? null),
            new SVo\ModifiedBy($m->modified_by ?? null),
            new SVo\ModifiedIp($m->modified_ip ?? null),
        );
    }

    public static function mapHistoryModelToDomain(EloquentHistory $h): DomainHistoryEntity
    {
        $accountStatus = $h->accountStatusMaster;

        return new DomainHistoryEntity(
            new SVo\Uuid((string)$h->id),
            new Vo\Id((string)$h->admin_account_id),
            new Vo\Email((string)$h->email),
            new Vo\Name((string)$h->name),
            new Vo\AdminNote((string)$h->admin_note),
            new Vo\AccountStatusMasterId((string)($h->account_status_master_id ?? null)),
            new Vo\AccountStatusMasterCode($accountStatus?->code ?? null),
            new Vo\AccountStatusMasterName($accountStatus?->name ?? null),
            new Vo\IsEmailVerified((string)($h->is_email_verified ? '1' : '0')),
            new Vo\PasswordChangedAt($h->password_changed_at?->format('Y-m-d\\TH:i:s') ?? null),
            new Vo\PasswordExpiresAt($h->password_expires_at?->format('Y-m-d\\TH:i:s') ?? null),
            new SVo\Created($h->created?->format('Y-m-d\\TH:i:s') ?? null),
            new SVo\CreatedBy($h->created_by ?? null),
            new SVo\CreatedIp($h->created_ip ?? null),
            new SVo\Modified($h->modified?->format('Y-m-d\\TH:i:s') ?? null),
            new SVo\ModifiedBy($h->modified_by ?? null),
            new SVo\ModifiedIp($h->modified_ip ?? null),
            new SVo\OperationType($h->operation_type ?? null),
            new SVo\HistoryCreated($h->history_created?->format('Y-m-d\\TH:i:s') ?? null),
        );
    }
}
