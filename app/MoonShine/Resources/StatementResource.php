<?php

namespace App\MoonShine\Resources;

use App\Models\Statement;
use App\Models\StatementStatus;
use Illuminate\Database\Eloquent\Model;

use Leeto\MoonShine\Fields\BelongsTo;
use Leeto\MoonShine\Fields\File;
use Leeto\MoonShine\Fields\HasMany;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Actions\FiltersAction;

class StatementResource extends Resource
{
	public static string $model = Statement::class;

	public static string $title = 'Заявления';

	public function fields(): array
	{
		return [
		    ID::make()->sortable(),
            BelongsTo::make(
                'Тип процедуры',
                'current_procedure_id',
                new ProcedureTypeResource()
            )
                ->showOnExport()
                ->sortable(),
            BelongsTo::make(
                'Статус',
                'statement_status_id',
                new StatementStatusResource()
            )
                ->showOnExport()
                ->sortable(),
            Text::make('Наименование', 'name')
                ->sortable()
                ->required(),
            Text::make('Комментарий', 'comment')
                ->sortable()
                ->required(),
            HasMany::make('Документы', 'files')
                ->fields(
                    [
                        ID::make(),
                        File::make('Файл', 'file')
                            ->removable()
                            ->disk('public')
                            ->dir('app/statement_files/')
                            ->keepOriginalFileName()
                            ->allowedExtensions(['doc', 'pdf', 'docx', 'xls', 'xlsx'])
                            ->sortable(),
                        Text::make('Имя', 'name'),
                    ]
                )
                ->removable()
                ->hideOnIndex(),
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
