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
    public function up(): void
    {
        $procedures = [
            'Первичная этическая экспертиза',
            'Повторная этическая экспертиза',
            'Порядок рассмотрения уведомлений',
            'Периодическая этическая экспертиза',
            'Отчётность по безопасности',
            'Итоговый отчёт',
            'Информационный листок пациента',
        ];

        Schema::table('statements', function (Blueprint $table){
            $table->dropForeign(['procedure_type_id']);
            $table->dropColumn('procedure_type_id');
            $table->unsignedTinyInteger('current_procedure_id');
        });
        Schema::rename('procedure_types', 'procedures');

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
    public function down(): void
    {
        Schema::rename('procedures', 'procedure_types');
        Schema::table('statements', function (Blueprint $table){
            $table->dropColumn('current_procedure_id');
            $table->unsignedBigInteger('procedure_type_id');
            $table->foreign(['procedure_type_id'])->references('id')->on('procedure_types')->cascadeOnDelete();
        });
    }
};
