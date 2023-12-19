<?php

namespace App\MoonShine\Resources;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Fields\BelongsTo;
use Leeto\MoonShine\Fields\CKEditor;
use Leeto\MoonShine\Fields\HasOne;
use Leeto\MoonShine\Fields\Image;
use Leeto\MoonShine\Fields\SwitchBoolean;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Fields\Textarea;
use Leeto\MoonShine\Filters\SwitchBooleanFilter;
use Leeto\MoonShine\Filters\TextFilter;

use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;

class PostResource extends Resource
{
    public static string $model = Post::class;

    public static string $title = 'Новости';


    public function fields(): array
    {
        return [
            Block::make(
                'form-container',
                [
                    ID::make()
                        ->sortable()
                        ->showOnExport(),
                    SwitchBoolean::make('Опубликовать', 'active')
                        ->onValue(1)
                        ->offValue(0)
                        ->sortable(),
                    Text::make('Наименование статьи', 'name')
                        ->sortable()
                        ->required(),
                    Text::make('Символьный код', 'slug')
                        ->sortable()->hideOnIndex(),
                    Image::make('Картинка', 'image')
                        ->removable()
                        ->showOnExport()
                        ->disk('public')
                        ->dir('/news_images/' . auth('moonshine')->id())
                        ->keepOriginalFileName()
                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'tif'])
                        ->hideOnIndex(),
                    CKEditor::make('Описание', 'preview')
                        ->showOnIndex(false),
                    CKEditor::make('Содержимое новости', 'detail_text')
                        ->showOnIndex(false),
                    HasOne::make('Настройки SEO', 'seoSetting')
                        ->fields([
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
        return ['id', 'preview', 'detail_text', 'preview'];
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Наименование статьи', 'name'),
            SwitchBooleanFilter::make('Опубликовано', 'active')
        ];
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
}
