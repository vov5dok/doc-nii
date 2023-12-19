<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('statement_status_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('statement_id');
            $table->foreignId('statement_status_id');

            // Опционально, если вы хотите хранить информацию о пользователе, который выполнил изменение статуса
            $table->unsignedBigInteger('user_id')->nullable();

            $table->index('statement_id');
            $table->index('user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('statement_status_histories');
    }
};
