<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $sql = <<<'SQL'

            DROP TABLE IF EXISTS login_logs;

            CREATE TABLE login_logs (
                id CHAR(36) NOT NULL COMMENT 'ログID(UUID)',
                login_id VARCHAR(255) NOT NULL COMMENT 'ログインID',
                login_actor_type VARCHAR(20) NOT NULL COMMENT 'アカウント種別:ADMIN / USER',
                account_id BIGINT UNSIGNED NULL COMMENT '対象アカウントID',
                impersonator_account_id BIGINT UNSIGNED NULL COMMENT '代理ログイン管理者ID',
                login_result VARCHAR(20) NOT NULL COMMENT 'ログイン結果:SUCCESS / FAILURE',
                ip_address VARCHAR(45) NOT NULL COMMENT 'IPアドレス',
                user_agent TEXT NULL COMMENT 'ユーザーエージェント',
                failure_reason_code VARCHAR(255) NULL COMMENT 'ログイン失敗理由コード',
                logged_in_at DATETIME NOT NULL COMMENT 'ログイン日時',
                created_at DATETIME(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
                PRIMARY KEY (id),
                INDEX login_logs_idx01 (logged_in_at, login_id, login_result),
                INDEX login_logs_idx02 (account_id, logged_in_at),
                INDEX login_logs_idx03 (impersonator_account_id, logged_in_at),
                INDEX login_logs_idx04 (login_id, logged_in_at)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='ログイン試行ログ'
            COLLATE=utf8mb4_0900_ai_ci;

        SQL;

        DB::unprepared($sql);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS login_logs;');
    }
};
