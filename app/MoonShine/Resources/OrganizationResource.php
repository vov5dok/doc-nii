<?php

namespace App\MoonShine\Resources;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Model;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Filters\TextFilter;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;

class OrganizationResource extends Resource
{
    public static string $model = Organization::class;

    public static string $title = 'Список организаций';
    public string $titleField = 'name';

    public function fields(): array
    {
        return [
            Block::make(
                'form-container',
                [
                    ID::make()->sortable(),
                    Text::make('Наименование организации', 'name')
                        ->showOnExport(),
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
        return ['id', 'name'];
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Наименование организации', 'name'),
        ];
    }

    public function actions(): array
    {
        return [];
    }
}
