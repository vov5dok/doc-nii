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
        Schema::table('moonshine_users', function (Blueprint $table) {
            $table->timestamp('email_verified_at')
                ->nullable();
            $table->string('second_name')
                ->nullable();
            $table->string('last_name')
                ->nullable();
            $table->string('organization')
                ->nullable();
            $table->string('position')
                ->nullable();
            $table->boolean('data_processing_permission')
                ->nullable();
            $table->boolean('active')
                ->nullable();
            $table->string('verify_token')
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
        Schema::table('moonshine_users', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
            $table->dropColumn('second_name');
            $table->dropColumn('last_name');
            $table->dropColumn('organization');
            $table->dropColumn('position');
            $table->dropColumn('data_processing_permission');
            $table->dropColumn('active');
            $table->dropColumn('verify_token');

        });

    }
};
