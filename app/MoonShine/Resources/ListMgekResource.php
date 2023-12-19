<?php

namespace App\MoonShine\Resources;

use App\Models\ListMgek;
use Illuminate\Database\Eloquent\Model;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Fields\File;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;

class ListMgekResource extends Resource
{
    public static string $model = ListMgek::class;

    public static string $title = 'Состав комитета';

    public function fields(): array
    {
        return [
            Block::make(
                'form-container',
                [
                    ID::make()
                        ->sortable(),
                    Text::make('Наименование документа', 'name')
                        ->sortable()
                        ->required(),
                    Text::make('Сортировка', 'sort')
                        ->sortable(),
                    File::make('Документ', 'document')
                        ->removable()
                        ->showOnExport()
                        ->disk('public')
                        ->dir('/mgek_list_docs/' . auth('moonshine')->id())
                        ->keepOriginalFileName()
                        ->allowedExtensions(['doc', 'pdf', 'docx', 'xls', 'xlsx']),
                ]
            )
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
        return [];
    }
}
