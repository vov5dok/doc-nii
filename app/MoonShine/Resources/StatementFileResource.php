<?php

namespace App\MoonShine\Resources;

use App\Models\StatementFile;
use Illuminate\Database\Eloquent\Model;

use Leeto\MoonShine\Fields\File;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Actions\FiltersAction;

class StatementFileResource extends Resource
{
	public static string $model = StatementFile::class;

	public static string $title = 'Файлы заявлений пользователей';

	public function fields(): array
	{
		return [
		    ID::make()->sortable(),
            Text::make('Имя', 'name')
                ->sortable(),
            File::make('Файл', 'file')
                ->removable()
                ->disk('public')
                ->dir('app/statement_files/')
                ->keepOriginalFileName()
                ->allowedExtensions(['doc', 'pdf', 'docx', 'xls', 'xlsx'])
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
}
