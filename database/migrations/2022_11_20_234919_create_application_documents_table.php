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
        Schema::create('application_documents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('sort')
                ->default(100);
            $table
                ->unsignedBigInteger('legal_manual_id');
            $table
                ->foreign('legal_manual_id')
                ->references('id')
                ->on('legal_manuals')
                ->cascadeOnDelete();
            $table->string('file')->default('');
            $table->string('name')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('application_documents', function (Blueprint $table) {
            $table->dropForeign(['legal_manual_id']);
        });

        Schema::dropIfExists('application_documents');
        Schema::enableForeignKeyConstraints();


    }
};
