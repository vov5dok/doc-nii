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
        Schema::create('seo_settings', function (Blueprint $table) {
            $table
                ->id()
                ->autoIncrement();
            $table->timestamps();
            $table->text('keywords')
                ->default('');
            $table->text('description')
                ->default('');
            $table->string('title')
                ->default('')
                ->nullable();
            $table->string('slug')
                ->default('')
                ->nullable();
            $table->unsignedBigInteger('post_id')
                ->nullable()
                ->unsigned();
            $table
                ->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');
            $table->unsignedBigInteger('legal_manual_id')
                ->nullable()
                ->unsigned();
            $table
                ->foreign('legal_manual_id')
                ->references('id')
                ->on('legal_manuals')
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
        Schema::dropIfExists('seo_settings');
    }
};
