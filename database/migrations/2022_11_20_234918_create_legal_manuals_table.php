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
        Schema::create('legal_manuals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')
                ->default('');
            $table->string('slug')
                ->unique();
            $table->integer('sort')
                ->default(100);
            $table->text('content')
                ->default('');
            $table->date('added_at')
                ->useCurrent()
                ->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('legal_manuals');

    }
};
