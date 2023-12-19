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
        Schema::create('expert_statement', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('expert_id')
                ->nullable();
            $table->unsignedBigInteger('statement_id')
                ->nullable();
            $table->string('status')
                ->nullable();
            $table->foreign('expert_id')
                ->references('id')
                ->on('moonshine_users');
            $table->foreign('statement_id')
                ->references('id')
                ->on('statements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expert_statement');
    }
};
