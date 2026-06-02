<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('password', 255);
            $table->string('name', 100);
            $table->unsignedBigInteger('account_status_master_id');
            $table->boolean('is_email_verified')->default(false);
            $table->dateTime('password_changed_at');
            $table->dateTime('password_expires_at');
            $table->timestamps();

            $table->foreign('account_status_master_id')
                ->references('id')
                ->on('account_status_masters')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_accounts');
    }
};
