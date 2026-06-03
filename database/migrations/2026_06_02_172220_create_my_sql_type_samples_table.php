<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $sql = <<<'SQL'

            DROP TABLE IF EXISTS my_sql_type_samples;

            CREATE TABLE my_sql_type_samples (
                -- Primary Key (UUIDv7)
                id CHAR(36) NOT NULL,

                /* ===== Numeric Types ===== */
                int_col INT,
                bigint_col BIGINT,
                decimal_col DECIMAL(10,2),
                float_col FLOAT,
                double_col DOUBLE,

                /* ===== Date & Time Types ===== */
                date_col DATE,
                time_col TIME,
                datetime_col DATETIME,

                /* ===== String Types ===== */
                char_col CHAR(10),
                varchar_col VARCHAR(255),

                text_col TEXT,
                mediumtext_col MEDIUMTEXT,
                longtext_col LONGTEXT,

                /* ===== JSON ===== */
                json_col JSON,

                /* ===== Search Column (日本語全文検索用) ===== */
                search_text LONGTEXT GENERATED ALWAYS AS (
                    CONCAT_WS(' ',
                        char_col,
                        varchar_col,
                        text_col,
                        mediumtext_col,
                        longtext_col
                    )
                ) STORED,

                /* ===== Index ===== */
                PRIMARY KEY (id),
                FULLTEXT KEY ft_search_text (search_text) WITH PARSER ngram
            )
            ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COLLATE=utf8mb4_0900_ai_ci;

        SQL;

        DB::unprepared($sql);
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS my_sql_type_samples;');
    }
};
