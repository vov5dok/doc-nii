<?php

namespace App\MoonShine\Resources;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Fields\File;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;

class DocumentResource extends Resource
{
    public static string $model = Document::class;

    public static string $title = 'Деятельность (регламентирующие документы)';

    public function fields(): array
    {
        return [
            Block::make('form-container', [
                ID::make()->sortable(),
                Text::make('Наименование документа', 'name')
                    ->sortable()
                    ->required(),
                File::make('Документ', 'document')
                    ->removable()
                    ->showOnExport()
                    ->disk('public')
                    ->dir('/legal_docs/' . auth('moonshine')->id())
                    ->keepOriginalFileName()
                    ->allowedExtensions(['doc', 'pdf', 'docx', 'xls', 'xlsx', 'tif']),
            ])
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return ['name', 'document'];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [];
    }

    protected function beforeCreating(Model $item)
    {
        $item->added_at = Carbon::now()->format('Y-m-d');
    }
}
