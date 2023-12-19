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
        Schema::table('moonshine_users', function (Blueprint $table) {
            $table
                ->timestamp('deactivation_date')
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
            $table->dropColumn('deactivation_date');
        });
    }
};
