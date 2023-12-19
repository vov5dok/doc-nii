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
        $procedures = [
            'Первичная этическая экспертиза',
            'Повторная этическая экспертиза',
            'Ускоренная этическая экспертиза',
            'Периодическая отчетность о ходе исследования',
            'Отчётность по безопасности',
            'Отчетность о завершении исследования',
            'Уведомление об административных изменениях',
            'Информационное письмо',
            'Другое',
        ];

        DB::table('procedures')->truncate();

        foreach ($procedures as $type) {
            $code = Str::slug($type, '-');
            DB::table('procedures')->insert([
                'name' => $type,
                'code' => $code,
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
        //
    }
};
