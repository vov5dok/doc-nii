<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private Collection $organizations;

    public function __construct()
    {
        $this->organizations = collect([
            'ГБУЗ "Городская клиническая больница № 13 ДЗМ"',
            'ГБУЗ "Городская клиническая больница имени Д.Д. Плетнёва ДЗМ"',
            'ГБУЗ "Городская поликлиника № 36 ДЗМ"',
            'ГБУЗ "Вороновская больница ДЗМ"',
            'ГБУЗ "Городская клиническая больница № 1 им. Н.И.Пирогова ДЗМ"',
            'ГБУЗ "Городская клиническая больница № 15 имени О.М. Филатова ДЗМ"',
            'ГБУЗ "Городская клиническая больница № 24 ДЗМ"',
            'ГБУЗ "Городская клиническая больница № 29 им. Н.Э. Баумана ДЗМ"',
            'ГБУЗ "Городская клиническая больница № 31 ДЗМ"',
            'ГБУЗ "Городская клиническая больница № 4 ДЗМ"',
            'ГБУЗ "Городская клиническая больница № 51 ДЗМ"',
            'ГБУЗ "Городская клиническая больница № 52 ДЗМ"',
            'ГБУЗ "Городская клиническая больница № 67 имени Л.А. Ворохобова ДЗМ"',
            'ГБУЗ "Городская клиническая больница №17 ДЗМ"',
            'ГБУЗ "Городская клиническая больница имени А.К. Ерамишанцева ДЗМ"',
            'ГБУЗ "Городская клиническая больница имени В.В. Вересаева ДЗМ"',
            'ГБУЗ "Городская клиническая больница имени В.В. Виноградова ДЗМ"',
            'ГБУЗ "Городская клиническая больница имени В.М. Буянова',
            'ГБУЗ "Городская клиническая больница имени В.П. Демихова" ДЗМ"',
            'ГБУЗ "Городская клиническая больница имени Е.О. Мухина ДЗМ"',
            'ГБУЗ "Городская клиническая больница имени И.В. Давыдовского ДЗМ"',
            'ГБУЗ "Городская клиническая больница имени М. П. Кончаловского ДЗМ"',
            'ГБУЗ "Городская клиническая больница имени М.Е. Жадкевича ДЗМ"',
            'ГБУЗ "Городская клиническая больница имени М.Е. Жадкевича ДЗМ" поликлиническое отделение',
            'ГБУЗ "Городская клиническая больница имени С.И. Спасокукоцкого ДЗМ"',
            'ГБУЗ "Городская клиническая больница имени С.П. Боткина ДЗМ"',
            'ГБУЗ "Городская клиническая больница имени С.С. Юдина ДЗМ"',
            'ГБУЗ "Городская клиническая больница имени Ф.И. Иноземцева ДЗМ"',
            'ГБУЗ "Городская клиническая онкологическая больница № 1 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 109 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 115 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 170 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 175 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 2 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 201 ДЗМ", в настоящее время входит в ГБУЗ г. Москвы "ГКБ им. М.П. Кончаловского" ПО №2',
            'ГБУЗ "Городская поликлиника № 202 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 210 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 212 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 219 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 220 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 3 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 46 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 52 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 6 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 62 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 64 ДЗМ"',
            'ГБУЗ "Городская поликлиника № 68 ДЗМ"',
            'ГБУЗ "Госпиталь для ветеранов войн № 2 ДЗМ"',
            'ГБУЗ "Детская городская клиническая больница № 13 имени Н.Ф. Филатова ДЗМ"',
            'ГБУЗ "Детская городская клиническая больница № 9 им. Г.Н. Сперанского ДЗМ"',
            'ГБУЗ "Детская городская клиническая больница имени З.А. Башляевой ДЗМ"',
            'ГБУЗ "Детская городская клиническая больница святого Владимира ДЗМ"',
            'ГБУЗ "Детская городская поликлиника № 110 ДЗМ"',
            'ГБУЗ "Детская городская поликлиника № 120 ДЗМ"',
            'ГБУЗ "Детская городская поликлиника № 129 ДЗМ"',
            'ГБУЗ "Детская городская поликлиника № 130 ДЗМ"',
            'ГБУЗ "Детская городская поликлиника № 133 ДЗМ"',
            'ГБУЗ "Детская городская поликлиника № 143 ДЗМ"',
            'ГБУЗ "Детская городская поликлиника № 148 ДЗМ"',
            'ГБУЗ "Детская городская поликлиника № 23 ДЗМ"',
            'ГБУЗ "Детская городская поликлиника № 61 ДЗМ"',
            'ГБУЗ "Детская городская поликлиника № 86 ДЗМ"',
            'ГБУЗ "Диагностический клинический центр № 1 ДЗМ"',
            'ГБУЗ "Диагностический центр № 5 ДЗМ"',
            'ГБУЗ "Инфекционная клиническая больница № 1 ДЗМ"',
            'ГБУЗ "Инфекционная клиническая больница № 2 ДЗМ"',
            'ГБУЗ "Консультативно-диагностическая поликлиника № 121 ДЗМ"',
            'ГБУЗ "Морозовская детская городская клиническая больница ДЗМ"',
            'ГБУЗ "Московская городская онкологическая больница № 62 ДЗМ"',
            'ГБУЗ "Московский городской научно-практический центр борьбы с туберкулезом ДЗМ"',
            'ГБУЗ "Московский клинический научно-практический центр имени А.С. Логинова ДЗМ"',
            'ГБУЗ "Московский многопрофильный клинический центр "Коммунарка" ДЗМ"',
            'ГБУЗ "Московский научно-практический Центр дерматовенерологии и косметологии ДЗМ"',
            'ГБУЗ "Московский научно-практический центр медицинской реабилитации, восстановительной и спортивной медицины ДЗМ"',
            'ГБУЗ "Московский научно-практический центр наркологии ДЗМ"',
            'ГБУЗ "Московский научно–практический Центр оториноларингологии им. Л.И. Свержевского ДЗМ"',
            'ГБУЗ "Научно-исследовательский институт неотложной детской хирургии и травматологии ДЗМ"',
            'ГБУЗ "Научно-исследовательский институт скорой помощи им. Н.В. Склифосовского ДЗМ"',
            'ГБУЗ "Научно-практический психоневрологический центр имени З.П. Соловьева ДЗМ"',
            'ГБУЗ "Научно-практический центр детской психоневрологии ДЗМ"',
            'ГБУЗ "Научно-практический центр специализированной медицинской помощи детям имени В.Ф. Войно-Ясенецкого ДЗМ"',
            'ГБУЗ "Онкологический клинический диспансер № 1 ДЗМ"',
            'ГБУЗ "Психиатрическая клиническая больница № 15 ДЗМ"',
            'ГБУЗ "Психиатрическая клиническая больница № 3 им. В. А. Гиляровского ДЗМ"',
            'ГБУЗ "Психиатрическая клиническая больница № 4 им. П.Б. Ганнушкина ДЗМ"',
            'ГБУЗ "Психиатрическая клиническая больница №1 им. Н.А. Алексеева ДЗМ"',
            'ГБУЗ "Эндокринологический диспансер ДЗМ"',
        ]);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->organizations->each(function (string $organization) {
            DB::table('organizations')->insert([
                'name'       => $organization,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::table('organizations')
            ->whereIn('name', $this->organizations->toArray())
            ->delete();
    }
};
