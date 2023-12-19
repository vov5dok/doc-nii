<?php

namespace App\MoonShine\Resources;

use App\Models\StatementStatus;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Actions\FiltersAction;

class StatementStatusResource extends Resource
{
	public static string $model = StatementStatus::class;

	public static string $title = 'Статус заявления';

    public string $titleField = 'name';


    public function fields(): array
	{
		return [
		    ID::make()->sortable(),
            Text::make('Имя', 'name')
                ->sortable(),
            Text::make('Символьный код', 'code')
                ->sortable(),
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

    protected function afterCreated(Model $item)
    {
        if ($item->code == '') {
            $item->code = Str::slug($item->code, '-');
            $item->save();
        }
    }

    protected function afterUpdated(Model $item)
    {
        if ($item->code == '') {
            $item->code = Str::slug($item->code, '-');
            $item->save();
        }
    }
}
