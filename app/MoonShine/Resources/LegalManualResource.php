<?php

namespace App\MoonShine\Resources;

use App\Models\LegalManual;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Fields\CKEditor;
use Leeto\MoonShine\Fields\File;
use Leeto\MoonShine\Fields\HasMany;
use Leeto\MoonShine\Fields\HasOne;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Fields\Textarea;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;


class LegalManualResource extends Resource
{
    public static string $model = LegalManual::class;

    public static string $title = 'Порядок рассмотрения документов';

    public function fields(): array
    {
        return [
            Block::make(
                'form-container',
                [
                    ID::make()->sortable(),
                    Text::make('Имя', 'name')
                        ->sortable(),
                    Text::make('Символьный код', 'slug')
                        ->sortable()
                        ->hideOnIndex(),
                    Text::make('Сортировка', 'sort')
                        ->sortable(),
                    CKEditor::make('Контент', 'content')
                        ->hideOnIndex(),
                    HasMany::make('Документы', 'files')
                        ->fields(
                            [
                                ID::make(),
                                File::make('Документ', 'file')
                                    ->removable()
                                    ->disk('public')
                                    ->dir('/docs/' . auth('moonshine')->id())
                                    ->keepOriginalFileName()
                                    ->allowedExtensions(['doc', 'pdf', 'docx', 'xls', 'xlsx']),
                                Text::make('Имя', 'name'),
                            ]
                        )
                        ->removable()
                        ->hideOnIndex(),
                    HasOne::make('Настройки SEO', 'seoSetting')
                        ->fields(
                            [
                                ID::make()
                                    ->sortable(),
                                Textarea::make('keywords')
                                    ->sortable(),
                                Textarea::make('description')
                                    ->sortable(),
                            ])
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

    protected function afterCreated(Model $item)
    {
        if ($item->slug == '') {
            $item->slug = Str::slug($item->name, '-');
            $item->save();
        }
    }

    protected function afterUpdated(Model $item)
    {
        if ($item->slug == '') {
            $item->slug = Str::slug($item->name, '-');
            $item->save();
        }
    }

    protected function beforeCreating(Model $item)
    {
        $item->added_at = Carbon::now()->format('Y-m-d');
    }
}
