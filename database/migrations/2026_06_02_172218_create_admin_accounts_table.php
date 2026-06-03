<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $sql = <<<'SQL'

            DROP TABLE IF EXISTS admin_accounts;

            CREATE TABLE admin_accounts (
                id BIGINT AUTO_INCREMENT COMMENT '管理者アカウントID',
                email VARCHAR(255) NOT NULL COMMENT 'ログインメールアドレス',
                password VARCHAR(255) NOT NULL COMMENT 'ハッシュ化パスワード',
                name VARCHAR(100) NOT NULL COMMENT '表示名',
                admin_note TEXT DEFAULT NULL COMMENT '管理者メモ（内部管理用）',
                account_status_master_id INT NOT NULL COMMENT 'アカウントステータスマスタID',
                is_email_verified INT NOT NULL DEFAULT 0 COMMENT 'メール確認済フラグ',
                password_changed_at DATETIME(0) NOT NULL COMMENT 'パスワード最終変更日時',
                password_expires_at DATETIME(0) NOT NULL COMMENT 'パスワード有効期限',
                
                created_at DATETIME(0) NOT NULL COMMENT '作成日時',
                created_by BIGINT DEFAULT NULL COMMENT '作成者管理者アカウントID',
                created_ip VARCHAR(45) DEFAULT NULL COMMENT '作成時IPアドレス',
                modified_at DATETIME(0) NOT NULL COMMENT '更新日時',
                modified_by BIGINT DEFAULT NULL COMMENT '更新者管理者アカウントID',
                modified_ip VARCHAR(45) DEFAULT NULL COMMENT '更新時IPアドレス',
                PRIMARY KEY (id),
                UNIQUE KEY admin_accounts_idx01 (email),
                INDEX admin_accounts_idx02 (name),
                INDEX admin_accounts_idx03 (account_status_master_id),
                INDEX admin_accounts_idx04 (is_email_verified),
                INDEX admin_accounts_idx05 (password_changed_at),
                INDEX admin_accounts_idx06 (password_expires_at)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            AUTO_INCREMENT=900000
            COMMENT='管理者アカウント'
            COLLATE=utf8mb4_0900_ai_ci;

            INSERT INTO admin_accounts (
                id,
                email,
                password,
                name,
                admin_note,
                account_status_master_id,
                is_email_verified,
                password_changed_at,
                password_expires_at,
                created_at,
                modified_at
            ) VALUES (
                900000,
                'system-reserved@example.local',
                'reserved',
                'SYSTEM_RESERVED',
                'AUTO_INCREMENT開始値確保用の予約レコード',
                900,
                1,
                '1970-01-01 00:00:00',
                '1970-01-01 00:00:00',
                '1970-01-01 00:00:00',
                '1970-01-01 00:00:00'
            );

            DROP TABLE IF EXISTS admin_account_histories;

            CREATE TABLE admin_account_histories (
                id CHAR(36) NOT NULL COMMENT '履歴ID',
                admin_account_id BIGINT NOT NULL COMMENT '管理者アカウントID',
                email VARCHAR(255) NOT NULL COMMENT 'ログインメールアドレス',
                password VARCHAR(255) NOT NULL COMMENT 'ハッシュ化パスワード',
                name VARCHAR(100) NOT NULL COMMENT '表示名',
                admin_note TEXT DEFAULT NULL COMMENT '管理者メモ（内部管理用）',
                account_status_master_id INT NOT NULL COMMENT 'アカウントステータスマスタID',
                is_email_verified INT NOT NULL DEFAULT 0 COMMENT 'メール確認済フラグ',
                password_changed_at DATETIME(0) NOT NULL COMMENT 'パスワード最終変更日時',
                password_expires_at DATETIME(0) NOT NULL COMMENT 'パスワード有効期限',
                
                created_at DATETIME(0) NOT NULL COMMENT '作成日時',
                created_by BIGINT DEFAULT NULL COMMENT '作成者管理者アカウントID',
                created_ip VARCHAR(45) DEFAULT NULL COMMENT '作成時IPアドレス',
                modified_at DATETIME(0) NOT NULL COMMENT '更新日時',
                modified_by BIGINT DEFAULT NULL COMMENT '更新者管理者アカウントID',
                modified_ip VARCHAR(45) DEFAULT NULL COMMENT '更新時IPアドレス',

                operation_type VARCHAR(10) NOT NULL COMMENT '操作種別 (INSERT / UPDATE / DELETE)',
                history_created DATETIME(0) NOT NULL COMMENT '履歴作成日時',

                PRIMARY KEY (id),
                INDEX admin_account_histories_idx01 (admin_account_id, history_created),
                INDEX admin_account_histories_idx02 (history_created)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='管理者アカウント変更履歴'
            COLLATE=utf8mb4_0900_ai_ci;

        SQL;

        DB::unprepared($sql);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS admin_accounts;');
        DB::unprepared('DROP TABLE IF EXISTS admin_account_histories;');
    }
};
