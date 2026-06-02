<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $sql = <<<'SQL'

            DROP TABLE IF EXISTS user_accounts;

            CREATE TABLE user_accounts (
                id BIGINT AUTO_INCREMENT COMMENT 'ユーザーアカウントID',
                email VARCHAR(255) NOT NULL COMMENT 'ログインメールアドレス',
                password VARCHAR(255) NOT NULL COMMENT 'ハッシュ化パスワード',
                name VARCHAR(100) NOT NULL COMMENT '表示名',
                account_status_master_id INT NOT NULL COMMENT 'アカウントステータスマスタID',
                is_email_verified INT NOT NULL DEFAULT 0 COMMENT 'メール確認済フラグ',
                password_changed_at DATETIME(0) NOT NULL COMMENT 'パスワード最終変更日時',
                password_expires_at DATETIME(0) NOT NULL COMMENT 'パスワード有効期限',
                created DATETIME(0) NOT NULL COMMENT '作成日時',
                created_by BIGINT DEFAULT NULL COMMENT '作成者アカウントID',
                created_ip VARCHAR(45) DEFAULT NULL COMMENT '作成時IPアドレス',
                modified DATETIME(0) NOT NULL COMMENT '更新日時',
                modified_by BIGINT DEFAULT NULL COMMENT '更新者アカウントID',
                modified_ip VARCHAR(45) DEFAULT NULL COMMENT '更新時IPアドレス',
                PRIMARY KEY (id),
                UNIQUE KEY user_accounts_idx01 (email),
                INDEX user_accounts_idx02 (name),
                INDEX user_accounts_idx03 (account_status_master_id),
                INDEX user_accounts_idx04 (is_email_verified),
                INDEX user_accounts_idx05 (password_changed_at),
                INDEX user_accounts_idx06 (password_expires_at)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            AUTO_INCREMENT=1000000
            COMMENT='ユーザーアカウント'
            COLLATE=utf8mb4_0900_ai_ci;

            INSERT INTO user_accounts (
                id,
                email,
                password,
                name,
                account_status_master_id,
                is_email_verified,
                password_changed_at,
                password_expires_at,
                created,
                modified
            ) VALUES (
                1000000,
                'system-reserved-user@example.local',
                'reserved',
                'SYSTEM_RESERVED_USER',
                900,
                1,
                '1970-01-01 00:00:00',
                '1970-01-01 00:00:00',
                '1970-01-01 00:00:00',
                '1970-01-01 00:00:00'
            );

            DROP TABLE IF EXISTS user_account_histories;

            CREATE TABLE user_account_histories (
                id CHAR(36) NOT NULL COMMENT '履歴ID',
                user_account_id BIGINT NOT NULL COMMENT 'ユーザーアカウントID',
                email VARCHAR(255) NOT NULL COMMENT 'ログインメールアドレス',
                password VARCHAR(255) NOT NULL COMMENT 'ハッシュ化パスワード',
                name VARCHAR(100) NOT NULL COMMENT '表示名',
                account_status_master_id INT NOT NULL COMMENT 'アカウントステータスマスタID',
                is_email_verified INT NOT NULL DEFAULT 0 COMMENT 'メール確認済フラグ',
                password_changed_at DATETIME(0) NOT NULL COMMENT 'パスワード最終変更日時',
                password_expires_at DATETIME(0) NOT NULL COMMENT 'パスワード有効期限',
                created DATETIME(0) NOT NULL COMMENT '作成日時',
                created_by BIGINT DEFAULT NULL COMMENT '作成者アカウントID',
                created_ip VARCHAR(45) DEFAULT NULL COMMENT '作成時IPアドレス',
                modified DATETIME(0) NOT NULL COMMENT '更新日時',
                modified_by BIGINT DEFAULT NULL COMMENT '更新者アカウントID',
                modified_ip VARCHAR(45) DEFAULT NULL COMMENT '更新時IPアドレス',
                operation_type VARCHAR(10) NOT NULL COMMENT '操作種別 (INSERT / UPDATE / DELETE)',
                history_created DATETIME(0) NOT NULL COMMENT '履歴作成日時',
                PRIMARY KEY (id),
                INDEX user_account_histories_idx01 (user_account_id, history_created),
                INDEX user_account_histories_idx02 (history_created)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='ユーザーアカウント変更履歴'
            COLLATE=utf8mb4_0900_ai_ci;

            DROP TABLE IF EXISTS refresh_tokens;

            CREATE TABLE refresh_tokens (
                id CHAR(36) NOT NULL COMMENT 'リフレッシュトークンID(UUID7)',
                user_account_id BIGINT NOT NULL COMMENT 'ユーザーアカウントID',
                expires_at DATETIME(0) NOT NULL COMMENT '有効期限',
                created DATETIME(0) NOT NULL COMMENT '作成日時',
                created_by BIGINT DEFAULT NULL COMMENT '作成者アカウントID',
                created_ip VARCHAR(45) DEFAULT NULL COMMENT '作成時IPアドレス',
                modified DATETIME(0) NOT NULL COMMENT '更新日時',
                modified_by BIGINT DEFAULT NULL COMMENT '更新者アカウントID',
                modified_ip VARCHAR(45) DEFAULT NULL COMMENT '更新時IPアドレス',
                PRIMARY KEY (id),
                INDEX refresh_tokens_idx01 (user_account_id),
                INDEX refresh_tokens_idx02 (expires_at)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='リフレッシュトークン'
            COLLATE=utf8mb4_0900_ai_ci;

        SQL;

        DB::statement($sql);
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS user_accounts;');
        DB::statement('DROP TABLE IF EXISTS user_account_histories;');
        DB::statement('DROP TABLE IF EXISTS refresh_tokens;');
    }
};
