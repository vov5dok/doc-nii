<?php

namespace App\MoonShine\Resources;

use App\Models\SeoSetting;
use Illuminate\Database\Eloquent\Model;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Fields\Textarea;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;

class SeoSettingResource extends Resource
{
    public static string $model = SeoSetting::class;

    public static string $title = 'Настройки SEO';

    public function fields(): array
    {
        return [
            Block::make(
                'form-container',
                [
                    ID::make()
                        ->sortable(),
                    Textarea::make('keywords')
                        ->sortable(),
                    Textarea::make('description')
                        ->sortable(),
                    Text::make('slug')
                        ->sortable(),
                    Text::make('title')
                        ->sortable(),
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
        return ['id', 'slug'];
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
