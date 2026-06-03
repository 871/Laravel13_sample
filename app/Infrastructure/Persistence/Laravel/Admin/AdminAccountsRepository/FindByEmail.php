<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Laravel\Admin\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Models\Admin\AdminAccount as EloquentModel;

final class FindByEmail
{
    public function __construct(private readonly Vo\Email $email)
    {
    }

    public function run(): ?DomainEntity
    {
        $model = EloquentModel::with('accountStatusMaster')->where('email', $this->email->toString())->first();

        return $model ? Mapper::mapModelToDomain($model) : null;
    }
}
