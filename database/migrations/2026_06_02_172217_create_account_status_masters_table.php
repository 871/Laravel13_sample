<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $sql = <<<'SQL'

            DROP TABLE IF EXISTS account_status_masters;

            CREATE TABLE account_status_masters (
                id INT NOT NULL COMMENT 'アカウントステータスID',
                code VARCHAR(50) NOT NULL COMMENT 'ステータスコード',
                name VARCHAR(100) NOT NULL COMMENT 'ステータス名',
                description VARCHAR(255) NULL COMMENT '説明',
                sort INT NOT NULL DEFAULT 0 COMMENT '表示順',
                is_active INT NOT NULL DEFAULT 1 COMMENT '有効フラグ',
                created DATETIME(0) NOT NULL,
                modified DATETIME(0) NOT NULL,
                PRIMARY KEY (id),
                UNIQUE KEY account_status_masters_idx01 (code)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='アカウントステータスマスタ'
            COLLATE=utf8mb4_0900_ai_ci;

            INSERT INTO account_status_masters
            (id, code, name, description, sort, is_active, created, modified)
            VALUES
            (100, 'PENDING', '仮登録', 'メール確認待ち状態', 1000, 1, '1970-01-01 00:00:00', '1970-01-01 00:00:00'),
            (200, 'ACTIVE', '有効', '通常利用可能', 2000, 1, '1970-01-01 00:00:00', '1970-01-01 00:00:00'),
            (810, 'SUSPENDED', '停止', '管理者による停止', 8100, 1, '1970-01-01 00:00:00', '1970-01-01 00:00:00'),
            (820, 'LOCKED', 'ロック', 'ログイン失敗などによるロック', 8200, 1, '1970-01-01 00:00:00', '1970-01-01 00:00:00'),
            (900, 'DELETED', '削除', '論理削除', 9000, 1, '1970-01-01 00:00:00', '1970-01-01 00:00:00');

        SQL;

        DB::unprepared($sql);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS account_status_masters;');
    }
};
