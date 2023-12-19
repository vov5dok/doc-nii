<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table
                ->timestamp('added_at')
                ->useCurrent()
                ->useCurrentOnUpdate();
            $table
                ->boolean('active')
                ->default(true);
            $table->string('name', 200);
            $table
                ->bigInteger('counter')
                ->default(0);
            $table->string('image');
            $table->text('preview');
            $table->text('detail_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
