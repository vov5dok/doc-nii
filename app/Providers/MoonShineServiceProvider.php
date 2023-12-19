<?php

namespace App\Providers;

use App\MoonShine\Resources\ProcedureTypeResource;
use App\MoonShine\Resources\StatementFileResource;
use App\MoonShine\Resources\StatementResource;
use App\MoonShine\Resources\StatementStatusResource;
use Illuminate\Support\ServiceProvider;
use Leeto\MoonShine\MoonShine;
use Leeto\MoonShine\Menu\MenuGroup;
use Leeto\MoonShine\Menu\MenuItem;
use Leeto\MoonShine\Resources\MoonShineUserResource;
use Leeto\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\DocumentResource;
use App\MoonShine\Resources\LegalManualResource;
use App\MoonShine\Resources\ListMgekResource;
use App\MoonShine\Resources\MeetingScheduleResource;
use App\MoonShine\Resources\OrganizationResource;
use App\MoonShine\Resources\PostResource;
use App\MoonShine\Resources\QuestionResource;
use App\MoonShine\Resources\MoonshineUserResource as CustomMoonShineUserResource;
use App\MoonShine\Resources\SeoSettingResource;
class MoonShineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app(MoonShine::class)->menu([

            MenuGroup::make(__('moonshine::ui.resource.system'), [
                MenuItem::make(__('moonshine::ui.resource.admins_title'), new MoonShineUserResource())
                    ->icon('users'),
                MenuItem::make(__('moonshine::ui.resource.role_title'), new MoonShineUserRoleResource())
                    ->icon('bookmark'),
                MenuItem::make('SEO настройки', new SeoSettingResource())
                    ->icon('bookmark'),
            ]),

            MenuGroup::make('Заявления от пользователей', [
                MenuItem::make('Тип процедуры', new ProcedureTypeResource()),
                MenuItem::make('Заявления', new StatementResource()),
                MenuItem::make('Файлы', new StatementFileResource()),
                MenuItem::make('Статус', new StatementStatusResource()),
            ]),

            MenuItem::make('Новости', new PostResource())
                ->icon('bookmark'),
            MenuItem::make('Часто задаваемые вопросы', new QuestionResource())
                ->icon('bookmark'),
            MenuItem::make('Документы', new DocumentResource())
                ->icon('bookmark'),
            MenuItem::make('Юридические руководства', new LegalManualResource())
                ->icon('bookmark'),
            MenuItem::make('Список МГЭК', new ListMgekResource())
                ->icon('bookmark'),
            MenuItem::make('Пользователи', new CustomMoonShineUserResource())
                ->icon('bookmark'),
            MenuItem::make('Организации', new OrganizationResource())
                ->icon('bookmark'),
            MenuItem::make('Расписание собраний', new MeetingScheduleResource())
                ->icon('bookmark'),

            MenuItem::make('Обратно на сайт', url('/')),
        ]);
    }
}
