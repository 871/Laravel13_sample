<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Models\Admin\AdminAccount as EloquentModel;
use DateTimeInterface;

final class Create
{
    public function __construct(private readonly DateTimeInterface $datetime)
    {
        // 処理なし
    }

    public function run(DomainEntity $entity): DomainEntity
    {
        $model = EloquentModel::create([
            'id' => null, // AUTO_INCREMENT
            'email' => $entity->email()->toString(),
            'password' => $entity->password()->toString(),
            'name' => $entity->name()->toString(),
            'admin_note' => $entity->adminNote()->toString(),
            'account_status_master_id' => $entity->accountStatusMasterId()->toString(),
            'is_email_verified' => $entity->isEmailVerified()->toIntOrNull() ?? 0,
            'password_changed_at' => $entity->passwordChangedAt()?->toString() ?? null,
            'password_expires_at' => $entity->passwordExpiresAt()?->toString() ?? null,
            'created' => $entity->createdAt()?->format('Y-m-d\\TH:i:s') ?? null,
            'created_by' => null, // TODO: 作成者管理者アカウントID
            'created_ip' => null, // TODO: 作成時IPアドレス
            'modified' => $this->datetime->format('Y-m-d\\TH:i:s'),
            'modified_by' => null, // TODO: 更新者管理者アカウントID
            'modified_ip' => null, // TODO: 更新時IPアドレス
        ]);

        $model = new EloquentModel();

        $model->id = $entity->id()->toString();
        $model->email = $entity->email()->toString();
        $model->password = $entity->password()->toString();
        $model->name = $entity->name()->toString();
        $model->admin_note = $entity->adminNote()->toString();
        $model->account_status_master_id = $entity->accountStatusMasterId()->toString();
        $model->is_email_verified = $entity->isEmailVerified()->toIntOrNull() ?? 0;
        $model->password_changed_at = $entity->passwordChangedAt()?->toString() ?? null;
        $model->password_expires_at = $entity->passwordExpiresAt()?->toString() ?? null;

/*
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT '管理者アカウントID',
  `email` varchar(255) NOT NULL COMMENT 'ログインメールアドレス',
  `password` varchar(255) NOT NULL COMMENT 'ハッシュ化パスワード',
  `name` varchar(100) NOT NULL COMMENT '表示名',
  `admin_note` text COMMENT '管理者メモ（内部管理用）',
  `account_status_master_id` int NOT NULL COMMENT 'アカウントステータスマスタID',
  `is_email_verified` int NOT NULL DEFAULT '0' COMMENT 'メール確認済フラグ',
  `password_changed_at` datetime NOT NULL COMMENT 'パスワード最終変更日時',
  `password_expires_at` datetime NOT NULL COMMENT 'パスワード有効期限',

  `created` datetime NOT NULL COMMENT '作成日時',
  `created_by` bigint DEFAULT NULL COMMENT '作成者管理者アカウントID',
  `created_ip` varchar(45) DEFAULT NULL COMMENT '作成時IPアドレス',
  `modified` datetime NOT NULL COMMENT '更新日時',
  `modified_by` bigint DEFAULT NULL COMMENT '更新者管理者アカウントID',
  `modified_ip` varchar(45) DEFAULT NULL COMMENT '更新時IPアドレス',
  */

        $model->save();

        return Mapper::mapModelToDomain($model->fresh());
    }
}
