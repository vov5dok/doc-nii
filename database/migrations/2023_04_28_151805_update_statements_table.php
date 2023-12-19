<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statements', function (Blueprint $table) {
            $table->foreignId('moonshine_user_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unsignedBigInteger('moonshine_user_update_id')
                ->nullable();
            $table->foreign('moonshine_user_update_id')
                ->references('id')
                ->on('moonshine_users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statements', function (Blueprint $table) {
            $table->dropForeign(['moonshine_user_update_id']);
            $table->dropColumn('moonshine_user_update_id');
            $table->dropForeign(['moonshine_user_id']);
            $table->dropColumn('moonshine_user_id');
        });

    }
};
