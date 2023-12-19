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
        Schema::create('statement_files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('statement_id');
            $table->foreign('statement_id')
                ->references('id')
                ->on('statements')
                ->onDelete('cascade');
            $table->string('file');
            $table->string('name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statement_files');
    }
};
