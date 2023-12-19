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
    public function up()
    {
        Schema::table('statements', function (Blueprint $table) {
            $table->unsignedBigInteger('statement_status_id');
            $table->foreign('statement_status_id')
                ->references('id')
                ->on('statement_statuses')
                ->onDelete('cascade');
            $table->dateTime('completed_at')
                ->nullable();
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
            $table->dropForeign(['statement_status_id']);
            $table->dropColumn('statement_status_id');
            $table->dropColumn('completed_at');
        });
    }
};
