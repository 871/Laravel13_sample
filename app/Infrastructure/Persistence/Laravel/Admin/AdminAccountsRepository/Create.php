<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Laravel\Admin\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Models\Admin\AdminAccount as EloquentModel;

final class Create
{
    public function __construct(private readonly DomainEntity $entity)
    {
    }

    public function run(): DomainEntity
    {
        $model = new EloquentModel();

        $model->id = $this->entity->id()->toString();
        $model->email = $this->entity->email()->toString();
        $model->password = $this->entity->password()->toString();
        $model->name = $this->entity->name()->toString();
        $model->admin_note = $this->entity->adminNote()->toString();
        $model->account_status_master_id = $this->entity->accountStatusMasterId()->toString();
        $model->is_email_verified = $this->entity->isEmailVerified()->toIntOrNull() ?? 0;
        $model->password_changed_at = $this->entity->passwordChangedAt()?->toString() ?? null;
        $model->password_expires_at = $this->entity->passwordExpiresAt()?->toString() ?? null;

        $model->save();

        return Mapper::mapModelToDomain($model->fresh());
    }
}
