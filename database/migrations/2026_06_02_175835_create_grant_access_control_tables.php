<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $sql = <<<'SQL'

            DROP TABLE IF EXISTS grant_roles;
            CREATE TABLE grant_roles (
                id BIGINT NOT NULL AUTO_INCREMENT COMMENT '権限ロールID',
                account_type VARCHAR(20) NOT NULL COMMENT 'アカウント種別:ADMIN / USER',
                code VARCHAR(100) NOT NULL COMMENT '権限ロールコード',
                name VARCHAR(100) NOT NULL COMMENT '権限ロール名',
                description VARCHAR(255) NULL COMMENT '説明',
                sort INT NOT NULL DEFAULT 0 COMMENT '表示順',
                is_active INT NOT NULL DEFAULT 1 COMMENT '有効フラグ（新規設定）',
                created DATETIME(0) NOT NULL COMMENT '作成日時',
                modified DATETIME(0) NOT NULL COMMENT '更新日時',
                /* ===== Search Column (日本語全文検索用) ===== */
                search_text LONGTEXT GENERATED ALWAYS AS (
                    CONCAT_WS(' ',
                        code,
                        name,
                        description
                    )
                ) STORED COMMENT '日本語全文検索用結合カラム',
                PRIMARY KEY (id),
                UNIQUE INDEX grant_roles_idx01 (account_type, code),
                INDEX grant_roles_idx02 (account_type, is_active, sort),
                FULLTEXT KEY grant_roles_idx03 (search_text) WITH PARSER ngram
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='権限ロール'
            COLLATE=utf8mb4_0900_ai_ci;

            DROP TABLE IF EXISTS grant_permissions;
            CREATE TABLE grant_permissions (
                id BIGINT NOT NULL AUTO_INCREMENT COMMENT '権限ID',
                account_type VARCHAR(20) NOT NULL COMMENT 'アカウント種別:ADMIN / USER',
                code VARCHAR(100) NOT NULL COMMENT '権限コード',
                name VARCHAR(100) NOT NULL COMMENT '権限名',
                description VARCHAR(255) NULL COMMENT '説明',
                sort INT NOT NULL DEFAULT 0 COMMENT '表示順',
                is_active INT NOT NULL DEFAULT 1 COMMENT '有効フラグ（新規設定）',
                created DATETIME(0) NOT NULL COMMENT '作成日時',
                modified DATETIME(0) NOT NULL COMMENT '更新日時',
                /* ===== Search Column (日本語全文検索用) ===== */
                search_text LONGTEXT GENERATED ALWAYS AS (
                    CONCAT_WS(' ',
                        code,
                        name,
                        description
                    )
                ) STORED COMMENT '日本語全文検索用結合カラム',
                PRIMARY KEY (id),
                UNIQUE INDEX grant_permissions_idx01 (account_type, code),
                INDEX grant_permissions_idx02 (account_type, is_active, sort),
                FULLTEXT KEY grant_permissions_idx03 (search_text) WITH PARSER ngram
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='権限'
            COLLATE=utf8mb4_0900_ai_ci;

            DROP TABLE IF EXISTS grant_account_roles;
            CREATE TABLE grant_account_roles (
                id CHAR(36) NOT NULL COMMENT 'アカウントロール付与ID',
                account_type VARCHAR(20) NOT NULL COMMENT 'アカウント種別:ADMIN / USER',
                account_id BIGINT NOT NULL COMMENT 'アカウントID',
                grant_role_id BIGINT NOT NULL COMMENT '権限ロールID',
                created DATETIME(0) NOT NULL COMMENT '作成日時',
                modified DATETIME(0) NOT NULL COMMENT '更新日時',
                PRIMARY KEY (id),
                UNIQUE INDEX grant_account_roles_idx01 (account_type, account_id, grant_role_id),
                INDEX grant_account_roles_idx02 (account_type, account_id),
                INDEX grant_account_roles_idx03 (grant_role_id)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='アカウント権限ロール紐付け'
            COLLATE=utf8mb4_0900_ai_ci;

            DROP TABLE IF EXISTS grant_role_permissions;
            CREATE TABLE grant_role_permissions (
                id CHAR(36) NOT NULL COMMENT 'ロール権限紐付けID',
                account_type VARCHAR(20) NOT NULL COMMENT 'アカウント種別:ADMIN / USER',
                grant_role_id BIGINT NOT NULL COMMENT '権限ロールID',
                grant_permission_id BIGINT NOT NULL COMMENT '権限ID',
                created DATETIME(0) NOT NULL COMMENT '作成日時',
                modified DATETIME(0) NOT NULL COMMENT '更新日時',
                PRIMARY KEY (id),
                UNIQUE INDEX grant_role_permissions_idx01 (account_type, grant_role_id, grant_permission_id),
                INDEX grant_role_permissions_idx02 (account_type, grant_permission_id)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='権限ロールと権限の紐付け'
            COLLATE=utf8mb4_0900_ai_ci;

            DROP TABLE IF EXISTS grant_account_permissions;
            CREATE TABLE grant_account_permissions (
                id CHAR(36) NOT NULL COMMENT 'アカウント個別権限付与ID',
                account_type VARCHAR(20) NOT NULL COMMENT 'アカウント種別:ADMIN / USER',
                account_id BIGINT NOT NULL COMMENT 'アカウントID',
                grant_permission_id BIGINT NOT NULL COMMENT '権限ID',
                created DATETIME(0) NOT NULL COMMENT '作成日時',
                modified DATETIME(0) NOT NULL COMMENT '更新日時',
                PRIMARY KEY (id),
                UNIQUE INDEX grant_account_permissions_idx01 (account_type, account_id, grant_permission_id),
                INDEX grant_account_permissions_idx02 (account_type, account_id),
                INDEX grant_account_permissions_idx03 (grant_permission_id)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='アカウント個別権限付与'
            COLLATE=utf8mb4_0900_ai_ci;

        SQL;

        DB::statement($sql);
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS grant_account_permissions;');
        DB::statement('DROP TABLE IF EXISTS grant_role_permissions;');
        DB::statement('DROP TABLE IF EXISTS grant_account_roles;');
        DB::statement('DROP TABLE IF EXISTS grant_permissions;');
        DB::statement('DROP TABLE IF EXISTS grant_roles;');
    }
};
