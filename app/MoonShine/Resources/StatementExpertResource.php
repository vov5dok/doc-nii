<?php

namespace App\MoonShine\Resources;

use App\Models\StatementExpert;
use Illuminate\Database\Eloquent\Model;

use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Actions\FiltersAction;

class StatementExpertResource extends Resource
{
	public static string $model = StatementExpert::class;

	public static string $title = 'StatementExpert';

	public function fields(): array
	{
		return [
		    ID::make()->sortable(),
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
