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
        Schema::table('statement_files', function (Blueprint $table) {
            $table->foreignId('statement_document_type_id')
                ->nullable()
                ->constrained()
                ->references('id')
                ->on('statement_document_types')
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
        Schema::table('statement_files', function (Blueprint $table) {
            $table->dropForeign(['statement_document_type_id']);
            $table->dropColumn('statement_document_type_id');
        });
    }
};
