<?php

namespace App\MoonShine\Resources;

use App\Models\MeetingSchedule;
use Illuminate\Database\Eloquent\Model;
use Leeto\MoonShine\Fields\Date;
use Leeto\MoonShine\Fields\HasMany;
use Leeto\MoonShine\Fields\Number;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Actions\FiltersAction;

class MeetingScheduleResource extends Resource
{
    public static string $model = MeetingSchedule::class;

    public static string $title = 'Режим работы';

    public function fields(): array
    {
        return [
            Block::make('form-container', [
                ID::make()
                    ->sortable(),
                Number::make('Сортировка', 'sort')
                    ->min(1)
                    ->max(9999)
                    ->sortable(),
                Number::make('Год', 'year')
                    ->min(1)
                    ->max(9999)
                    ->sortable(),
                HasMany::make('Расписание встреч на год', 'meetings')
                    ->fields(
                        [
                            ID::make(),
                            Text::make('Сортировка', 'sort')
                                ->sortable(),
                            Date::make('Дата встречи', 'meeting_date')
                                ->withTime(),
                            Date::make('Исправленная дата встречи', 'meeting_date_correct')
                                ->withTime(),
                        ]
                    )
                    ->removable()
                    ->hideOnIndex(),
            ])
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return ['id'];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }



}
