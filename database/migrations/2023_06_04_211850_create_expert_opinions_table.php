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
        Schema::create('expert_opinions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('text')->nullable();
            $table->unsignedBigInteger('moonshine_user_id');
            $table->foreign('moonshine_user_id')
                ->references('id')
                ->on('moonshine_users')
                ->onDelete('cascade');

            $table->unsignedBigInteger('statement_id');
            $table->foreign('statement_id')
                ->references('id')
                ->on('statements')
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
        Schema::dropIfExists('expert_opinions');
    }
};
