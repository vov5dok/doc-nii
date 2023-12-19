<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('moonshine_user_roles', function (Blueprint $table) {
            $table->string('code')
                ->nullable();
        });

        DB::table('moonshine_user_roles')->insert(
            [
                [
                    'id' => 2,
                    'name' => 'Неактивный пользователь',
                    'code' => 'inactive'
                ],
                [
                    'id' => 3,
                    'name' => 'Участник',
                    'code' => 'participant'
                ],
                [
                    'id' => 4,
                    'name' => 'Заявитель',
                    'code' => 'applicant'
                ],
                [
                    'id' => 5,
                    'name' => 'Сотрудник',
                    'code' => 'employee'
                ],
            ],
        );

        DB::table('moonshine_user_roles')
            ->where('id', 1)
            ->update(
                ['code' => 'admin']
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moonshine_user_roles', function (Blueprint $table) {
            $table->dropColumn('code');
        });

        DB::table('moonshine_user_roles')->delete(2);
        DB::table('moonshine_user_roles')->delete(3);
        DB::table('moonshine_user_roles')->delete(4);
        DB::table('moonshine_user_roles')->delete(5);

    }
};
