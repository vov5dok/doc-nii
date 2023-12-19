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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('meeting_schedule_id');

            $table
                ->foreign('meeting_schedule_id')
                ->references('id')
                ->on('meeting_schedules')
                ->cascadeOnDelete();

            $table
                ->timestamp('meeting_date')
                ->nullable();

            $table
                ->timestamp('meeting_date_correct')
                ->nullable();

            $table->integer('sort')
                ->default('100')
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
        Schema::dropIfExists('meetings');
    }

};
