<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('my_sql_type_samples', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('int_col')->nullable();
            $table->bigInteger('bigint_col')->nullable();
            $table->decimal('decimal_col', 10, 2)->nullable();
            $table->float('float_col')->nullable();
            $table->double('double_col')->nullable();
            $table->date('date_col')->nullable();
            $table->time('time_col')->nullable();
            $table->dateTime('datetime_col')->nullable();
            $table->char('char_col', 10)->nullable();
            $table->string('varchar_col', 255)->nullable();
            $table->text('text_col')->nullable();
            $table->mediumText('mediumtext_col')->nullable();
            $table->longText('longtext_col')->nullable();
            $table->json('json_col')->nullable();
            $table->longText('search_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('my_sql_type_samples');
    }
};
