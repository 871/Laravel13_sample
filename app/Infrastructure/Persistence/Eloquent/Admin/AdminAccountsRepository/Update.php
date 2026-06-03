<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Models\Admin\AdminAccount as EloquentModel;

final class Update
{
    public function __construct(private readonly DomainEntity $entity)
    {
    }

    public function run(): DomainEntity
    {
        $id = $this->entity->id()->toString();
        $model = EloquentModel::findOrFail($id);

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
