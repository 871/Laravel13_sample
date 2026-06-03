<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Laravel\Admin;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Domain\Admin\AdminAccounts\Entity\AdminAccountHistory as DomainHistoryEntity;
use App\Domain\Admin\AdminAccounts\Repository\AdminAccountsRepository as DomainRepository;
use App\Domain\Admin\AdminAccounts\SearchCondition;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use App\Models\Admin\AdminAccount as EloquentModel;
use App\Models\Admin\AdminAccountHistory as EloquentHistory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

final class AdminAccountsRepository implements DomainRepository
{
    public function __construct(private readonly DateTimeInterface $datetime)
    {
    }

    public function search(SearchCondition $condition): array
    {
        $query = EloquentModel::query()->with('accountStatusMaster');

        $id = $condition->getId()->toStringOrNull();
        if ($id !== null && $id !== '') {
            $query->where('id', $id);
        }

        $statusId = $condition->getAccountStatusMasterId()->toStringOrNull();
        if ($statusId !== null && $statusId !== '') {
            $query->where('account_status_master_id', $statusId);
        }

        $keyword = $condition->getKeyword()->toQueryLikeOrNull();
        if ($keyword !== null && $keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('email', 'like', $keyword)
                  ->orWhere('name', 'like', $keyword);
            });
        }

        $models = $query->get();

        $results = [];
        foreach ($models as $model) {
            $results[] = $this->mapModelToDomain($model);
        }

        return $results;
    }

    public function create(DomainEntity $entity): DomainEntity
    {
        $model = new EloquentModel();

        // Populate fields from domain entity
        $model->id = $entity->id()->toString();
        $model->email = $entity->email()->toString();
        $model->password = $entity->password()->toString();
        $model->name = $entity->name()->toString();
        $model->admin_note = $entity->adminNote()->toString();
        $model->account_status_master_id = $entity->accountStatusMasterId()->toString();
        $model->is_email_verified = $entity->isEmailVerified()->toIntOrNull() ?? 0;
        $model->password_changed_at = $entity->passwordChangedAt()?->toString() ?? null;
        $model->password_expires_at = $entity->passwordExpiresAt()?->toString() ?? null;

        $model->save();

        return $this->mapModelToDomain($model->fresh());
    }

    public function read(Vo\Id $id): DomainEntity
    {
        try {
            $model = EloquentModel::with('accountStatusMaster')->findOrFail($id->toString());
        } catch (ModelNotFoundException $e) {
            throw $e; // Let caller handle not found
        }

        return $this->mapModelToDomain($model);
    }

    public function update(DomainEntity $entity): DomainEntity
    {
        $id = $entity->id()->toString();
        $model = EloquentModel::findOrFail($id);

        $model->email = $entity->email()->toString();
        $model->password = $entity->password()->toString();
        $model->name = $entity->name()->toString();
        $model->admin_note = $entity->adminNote()->toString();
        $model->account_status_master_id = $entity->accountStatusMasterId()->toString();
        $model->is_email_verified = $entity->isEmailVerified()->toIntOrNull() ?? 0;
        $model->password_changed_at = $entity->passwordChangedAt()?->toString() ?? null;
        $model->password_expires_at = $entity->passwordExpiresAt()?->toString() ?? null;

        $model->save();

        return $this->mapModelToDomain($model->fresh());
    }

    public function delete(Vo\Id $id): DomainEntity
    {
        $model = EloquentModel::findOrFail($id->toString());

        // Create history entry before deleting
        $history = new EloquentHistory();
        $history->id = (string) Str::uuid();
        $history->admin_account_id = $model->id;
        $history->email = $model->email;
        $history->password = $model->password;
        $history->name = $model->name;
        $history->admin_note = $model->admin_note;
        $history->account_status_master_id = $model->account_status_master_id;
        $history->is_email_verified = $model->is_email_verified;
        $history->password_changed_at = $model->password_changed_at;
        $history->password_expires_at = $model->password_expires_at;
        $history->created = $model->created;
        $history->created_by = $model->created_by ?? null;
        $history->created_ip = $model->created_ip ?? null;
        $history->modified = $model->modified;
        $history->modified_by = $model->modified_by ?? null;
        $history->modified_ip = $model->modified_ip ?? null;
        $history->operation_type = 'DELETE';
        $history->history_created = $this->datetime->format('Y-m-d\TH:i:s');
        $history->save();

        // delete the model
        $model->delete();

        return $this->mapHistoryModelToDomain($history);
    }

    public function readHistories(Vo\Id $adminAccountId): array
    {
        $models = EloquentHistory::with('accountStatusMaster')
            ->where('admin_account_id', $adminAccountId->toString())
            ->orderBy('history_created', 'desc')
            ->get();

        $results = [];
        foreach ($models as $m) {
            $results[] = $this->mapHistoryModelToDomain($m);
        }

        return $results;
    }

    public function findByEmail(Vo\Email $email): ?DomainEntity
    {
        $model = EloquentModel::with('accountStatusMaster')->where('email', $email->toString())->first();

        return $model ? $this->mapModelToDomain($model) : null;
    }

    private function mapModelToDomain(EloquentModel $m): DomainEntity
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
            new Vo\PasswordChangedAt($m->password_changed_at?->format('Y-m-d\TH:i:s') ?? null),
            new Vo\PasswordExpiresAt($m->password_expires_at?->format('Y-m-d\TH:i:s') ?? null),
            new SVo\Created($m->created?->format('Y-m-d\TH:i:s') ?? null),
            new SVo\CreatedBy($m->created_by ?? null),
            new SVo\CreatedIp($m->created_ip ?? null),
            new SVo\Modified($m->modified?->format('Y-m-d\TH:i:s') ?? null),
            new SVo\ModifiedBy($m->modified_by ?? null),
            new SVo\ModifiedIp($m->modified_ip ?? null),
        );
    }

    private function mapHistoryModelToDomain(EloquentHistory $h): DomainHistoryEntity
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
            new Vo\PasswordChangedAt($h->password_changed_at?->format('Y-m-d\TH:i:s') ?? null),
            new Vo\PasswordExpiresAt($h->password_expires_at?->format('Y-m-d\TH:i:s') ?? null),
            new SVo\Created($h->created?->format('Y-m-d\TH:i:s') ?? null),
            new SVo\CreatedBy($h->created_by ?? null),
            new SVo\CreatedIp($h->created_ip ?? null),
            new SVo\Modified($h->modified?->format('Y-m-d\TH:i:s') ?? null),
            new SVo\ModifiedBy($h->modified_by ?? null),
            new SVo\ModifiedIp($h->modified_ip ?? null),
            new SVo\OperationType($h->operation_type ?? null),
            new SVo\HistoryCreated($h->history_created?->format('Y-m-d\TH:i:s') ?? null),
        );
    }
}
