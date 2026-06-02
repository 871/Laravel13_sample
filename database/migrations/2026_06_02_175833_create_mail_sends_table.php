<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $sql = <<<'SQL'


            DROP TABLE IF EXISTS mails;
            CREATE TABLE mails (
                id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'メールID',
                original_message_id VARCHAR(255) NULL COMMENT '元メール Message-ID',
                related_data_key VARCHAR(255) NOT NULL COMMENT '関連データキー',
                send_status VARCHAR(20) NOT NULL COMMENT 'ステータス: WAITING / SENT / FAILED / RECEIVED / BOUNCED',
                -- WAITING: 送信待ち
                -- SENT: 送信済み（送信成功かつ受信確認前）
                -- RECEIVED: 受信確認済み
                -- BOUNCED: バウンス確認済み
                -- FAILED: 送信失敗（送信サーバエラー）
                -- 優先順位高い順: WAITING → SENT → RECEIVED → BOUNCED → FAILED
                send_scheduled_at DATETIME(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) COMMENT '送信予定日時',
                title VARCHAR(255) NOT NULL COMMENT 'メールタイトル',
                body MEDIUMTEXT NOT NULL COMMENT 'メール本文',
                mail_to TEXT NOT NULL COMMENT '送信先メールアドレス',
                mail_cc TEXT NULL COMMENT 'CCメールアドレス',
                mail_bcc TEXT NULL COMMENT 'BCCメールアドレス',

                mail_received_check VARCHAR(255) NOT NULL COMMENT '受信確認メールアドレス',
                mail_return_path VARCHAR(255) NOT NULL COMMENT 'バウンス確認メールアドレス',

                created DATETIME(0) NOT NULL COMMENT '作成日時',
                created_by BIGINT DEFAULT NULL COMMENT '作成者アカウントID',
                created_ip VARCHAR(45) DEFAULT NULL COMMENT '作成時IPアドレス',
                modified DATETIME(0) NOT NULL COMMENT '更新日時',
                modified_by BIGINT DEFAULT NULL COMMENT '更新者アカウントID',
                modified_ip VARCHAR(45) DEFAULT NULL COMMENT '更新時IPアドレス',
                /* ===== Search Column (日本語全文検索用) ===== */
                search_text LONGTEXT GENERATED ALWAYS AS (
                    CONCAT_WS(' ',
                        title,
                        body,
                        mail_to,
                        mail_cc,
                        mail_bcc
                    )
                ) STORED COMMENT '日本語全文検索用結合カラム',

                PRIMARY KEY (id),
                UNIQUE INDEX mail_infos_idx01 (related_data_key),
                INDEX mail_infos_idx02 (send_status, send_scheduled_at),
                INDEX mail_infos_idx03 (send_scheduled_at, send_status),
                INDEX mail_infos_idx04 (original_message_id),
                FULLTEXT KEY mail_infos_idx05 (search_text) WITH PARSER ngram
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='メール送信情報'
            COLLATE=utf8mb4_0900_ai_ci;


            DROP TABLE IF EXISTS mail_sent_logs;
            CREATE TABLE mail_sent_logs (
                id CHAR(36) NOT NULL COMMENT '送信ログID',
                mail_id BIGINT NOT NULL COMMENT 'メールID',
                original_message_id VARCHAR(255) NULL COMMENT '元メール Message-ID',
                send_status VARCHAR(20) NOT NULL COMMENT '送信ステータス: SENT / FAILED',
                error_message TEXT NULL COMMENT 'エラーメッセージ（失敗時）',
                sent_at DATETIME(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) COMMENT '送信日時',

                created DATETIME(0) NOT NULL COMMENT '作成日時',
                created_by BIGINT DEFAULT NULL COMMENT '作成者アカウントID',
                created_ip VARCHAR(45) DEFAULT NULL COMMENT '作成時IPアドレス',

                PRIMARY KEY (id),
                INDEX mail_sent_logs_idx01 (mail_id),
                INDEX mail_sent_logs_idx02 (original_message_id)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='メール送信ログ'
            COLLATE=utf8mb4_0900_ai_ci;


            DROP TABLE IF EXISTS mail_received_check_logs;
            CREATE TABLE mail_received_check_logs (
                id CHAR(36) NOT NULL COMMENT '受信確認ログID',
                mail_id BIGINT NOT NULL COMMENT 'メールID',
                original_message_id VARCHAR(255) NULL COMMENT '元メール Message-ID',
                checked_address VARCHAR(255) NOT NULL COMMENT '確認対象メールアドレス',
                checked_at DATETIME(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) COMMENT '確認日時',

                created DATETIME(0) NOT NULL COMMENT '作成日時',
                created_by BIGINT DEFAULT NULL COMMENT '作成者アカウントID',
                created_ip VARCHAR(45) DEFAULT NULL COMMENT '作成時IPアドレス',

                PRIMARY KEY (id),
                INDEX mail_received_check_logs_idx01 (mail_id),
                INDEX mail_received_check_logs_idx02 (original_message_id)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='メール受信確認ログ'
            COLLATE=utf8mb4_0900_ai_ci;


            DROP TABLE IF EXISTS mail_bounce_logs;
            CREATE TABLE mail_bounce_logs (
                id CHAR(36) NOT NULL COMMENT 'バウンスログID',
                mail_id BIGINT UNSIGNED NULL COMMENT '元メールID',
                original_message_id VARCHAR(255) NULL COMMENT '元メール Message-ID',
                bounced_email VARCHAR(255) NOT NULL COMMENT '配送失敗メールアドレス',
                recipient_type VARCHAR(20) NULL COMMENT 'TO / CC / BCC',
                action VARCHAR(50) NULL COMMENT 'failed / delayed / delivered',
                status_code VARCHAR(20) NULL COMMENT 'RFC3463 status code 5.1.1',
                diagnostic_code TEXT NULL COMMENT 'SMTP詳細エラー',
                bounce_type VARCHAR(20) NOT NULL COMMENT 'HARD / SOFT / BLOCK / SPAM / UNKNOWN',
                remote_mta VARCHAR(255) NULL COMMENT '失敗先SMTPサーバ',
                reporting_mta VARCHAR(255) NULL COMMENT 'バウンス生成サーバ',
                arrival_date DATETIME NULL COMMENT '配送試行日時',
                bounced_at DATETIME NOT NULL COMMENT 'バウンス受信日時',
                raw_headers MEDIUMTEXT NULL COMMENT 'RAWヘッダ',
                raw_body MEDIUMTEXT NULL COMMENT 'RAW本文',
                raw_message LONGTEXT NULL COMMENT 'RFC822全文',
                parsed_json JSON NULL COMMENT '解析済み構造JSON',
                provider VARCHAR(100) NULL COMMENT 'gmail / outlook / ses 等',
                is_auto_generated TINYINT(1) NOT NULL DEFAULT 1 COMMENT '自動生成メール',
                created DATETIME(0) NOT NULL COMMENT '作成日時',
                created_by BIGINT DEFAULT NULL COMMENT '作成者アカウントID',
                created_ip VARCHAR(45) DEFAULT NULL COMMENT '作成時IPアドレス',

                PRIMARY KEY (id),
                UNIQUE INDEX mail_bounce_logs_idx01 (mail_id, bounced_email),
                INDEX mail_bounce_logs_idx02 (original_message_id),
                INDEX mail_bounce_logs_idx03 (bounced_email),
                INDEX mail_bounce_logs_idx04 (status_code),
                INDEX mail_bounce_logs_idx05 (bounce_type),
                INDEX mail_bounce_logs_idx06 (bounced_at)
            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COMMENT='メールバウンスログ'
            COLLATE=utf8mb4_0900_ai_ci;
        SQL;

        DB::statement($sql);
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS mails;');
        DB::statement('DROP TABLE IF EXISTS mail_sent_logs;');
        DB::statement('DROP TABLE IF EXISTS mail_received_check_logs;');
        DB::statement('DROP TABLE IF EXISTS mail_bounce_logs;');
    }
};
