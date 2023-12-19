<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
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

        Schema::table('statements', function (Blueprint $table){
            $table->dropForeign(['statement_status_id']);
        });

        DB::table('statement_statuses')->truncate();

        foreach ($names as $name) {
            $code = Str::slug($name, '-');
            DB::table('statement_statuses')->insert([
                'name'       => $name,
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
    public function down(): void
    {
        $names = collect([
            'новое',
            'изменено заявителем',
            'изменено сотрудником',
            'на рассмотрении',
            'принято решение',
            'принято к сведению',
            'завершено'
        ]);

        DB::table('statement_statuses')
            ->whereIn('name', $names)
            ->delete();
    }
};
