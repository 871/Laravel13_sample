<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Laravel\Admin\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Models\Admin\AdminAccount as EloquentModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class Read
{
    public function __construct(private readonly Vo\Id $id)
    {
    }

    public function run(): DomainEntity
    {
        try {
            $model = EloquentModel::with('accountStatusMaster')->findOrFail($this->id->toString());
        } catch (ModelNotFoundException $e) {
            throw $e;
        }

        return Mapper::mapModelToDomain($model);
    }
}
