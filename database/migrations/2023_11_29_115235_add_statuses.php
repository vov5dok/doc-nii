<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $names = [
            'новое',
            'изменено заявителем',
            'изменено сотрудником',
            'на рассмотрении',
            'принято решение',
            'принято к сведению',
            'завершено'
        ];

        $fullNames = [
            'Новое заявление',
            'Заявление изменено заявителем',
            'Заявление изменено сотрудником',
            'Заявление на рассмотрении',
            'Принято решение по заявлению',
            'Заявление принято к сведению',
            'Рассмотрение завершено'
        ];

        DB::table('statement_statuses')->truncate();

        foreach ($names as $id => $name) {
            $code = Str::slug($name, '-');
            DB::table('statement_statuses')->insert([
                'name'       => $name,
                'full_name'  => $fullNames[$id],
                'code'       => $code,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $names = [
            'новое',
            'изменено заявителем',
            'изменено сотрудником',
            'на рассмотрении',
            'принято решение',
            'принято к сведению',
            'завершено'
        ];

        foreach ($names as $name) {
            DB::table('statement_statuses')->where('name', $name)->update(['full_name' => null]);
        }
    }
};
