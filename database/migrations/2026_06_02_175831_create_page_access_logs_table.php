<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $sql = <<<'SQL'

            DROP TABLE IF EXISTS page_access_logs;

            CREATE TABLE page_access_logs (
                id CHAR(36) NOT NULL COMMENT 'ログID(UUID7)',
                accessed DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)  COMMENT 'アクセス日時',
                account_type VARCHAR(20) NOT NULL COMMENT 'アカウント種別:ADMIN / USER',
                account_id BIGINT UNSIGNED NOT NULL COMMENT '対象アカウントID',
                method VARCHAR(10) NOT NULL COMMENT 'アクセスメソッド',
                path VARCHAR(2048) NOT NULL COMMENT ' パス',
                query_string TEXT NULL COMMENT ' GETパラメータ',
                post_keys TEXT NULL COMMENT ' POSTパラメータキー',
                route_name VARCHAR(2048) NULL COMMENT 'コントローラ-メソッド',
                referer TEXT NULL COMMENT ' リファラ',
                ip_address VARCHAR(45) NULL COMMENT ' IPアドレス',
                user_agent TEXT NULL COMMENT ' ユーザエージェント',
                created DATETIME(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
                search_key VARCHAR(50) GENERATED ALWAYS AS (
                    CONCAT_WS('-',
                        DATE_FORMAT(accessed, '%Y%m%d%H%i%s%f'),
                        account_id
                    )
                ) STORED COMMENT '検索用結合キー',
                PRIMARY KEY (id),
                UNIQUE INDEX page_access_logs_idx01 (search_key),
                INDEX page_access_logs_idx02 (accessed, account_id),
                INDEX page_access_logs_idx03 (accessed, method)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='ページアクセスログ'
            COLLATE=utf8mb4_0900_ai_ci;

        SQL;

        DB::unprepared($sql);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS page_access_logs;');
    }
};
