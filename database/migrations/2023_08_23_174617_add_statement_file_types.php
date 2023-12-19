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
        $documentTypes = [
            'документ заявителя',
            'документ о регистрации',
            'документ о принятом решении',
            'документ эксперта'
        ];

        Schema::table('statement_files', function (Blueprint $table){
            $table->dropForeign(['statement_document_type_id']);
            $table->dropColumn('statement_document_type_id');
            $table->unsignedTinyInteger('statement_file_type_id');
        });
        Schema::rename('statement_document_types', 'statement_file_types');

        DB::table('statement_file_types')->truncate();

        foreach ($documentTypes as $type) {
            $code = Str::slug($type, '-');
            DB::table('statement_file_types')->insert([
                'name'       => $type,
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

    }
};
