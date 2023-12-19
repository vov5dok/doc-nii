<?php

namespace App\MoonShine\Resources;

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Fields\Code;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;

class QuestionResource extends Resource
{
    public static string $model = Question::class;

    public static string $title = 'Часто задаваемые вопросы';

    public function fields(): array
    {
        return [
            Block::make(
                'form-container',
                [
                    ID::make()->sortable(),
                    Text::make('Вопрос', 'question')
                        ->sortable()
                        ->required(),
                    Code::make('Ответ', 'answer')
                        ->language('html')
                        ->hideOnIndex()
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
        return ['question', 'answer'];
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
