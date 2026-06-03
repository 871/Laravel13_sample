<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Models\Admin\AdminAccount as EloquentModel;
use App\Models\Admin\AdminAccountHistory as EloquentHistory;
use DateTimeInterface;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

final class Delete
{
    public function __construct(
        private readonly Vo\Id $id, 
        private readonly DateTimeInterface $datetime)
    {
        // 処理なし
    }

    public function run(): DomainEntity
    {
        $model = EloquentModel::findOrFail($this->id->toString());
        $results = Mapper::mapModelToDomain($model->fresh());
        
        $history = new EloquentHistory();
        $history->id = (string) Uuid::uuid7()->toString();
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
        $history->history_created = $this->datetime->format('Y-m-d\\TH:i:s');
        $history->save();

        $model->delete();

        return $results;
    }
}
