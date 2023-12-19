<?php

namespace App\MoonShine\Resources;

use App\Mail\WelcomeMail;
use App\Models\MoonshineUser;
use Illuminate\Database\Eloquent\Model;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Fields\BelongsTo;
use Leeto\MoonShine\Fields\Date;
use Leeto\MoonShine\Fields\Email;
use Leeto\MoonShine\Fields\Image;
use Leeto\MoonShine\Fields\Password;
use Leeto\MoonShine\Fields\PasswordRepeat;
use Leeto\MoonShine\Fields\SwitchBoolean;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Resources\MoonShineUserRoleResource;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Illuminate\Support\Facades\Mail;


class MoonshineUserResource extends Resource
{
    public static string $model = MoonshineUser::class;

    public static string $title = 'Пользователи (для сотрудников МГЭК)';

    public function fields(): array
    {
        return [
            Block::make(
                'form-container',
                [
                    ID::make()
                        ->sortable()
                        ->showOnExport(),

                    BelongsTo::make(
                        trans('moonshine::ui.resource.role'),
                        'moonshine_user_role_id',
                        new MoonShineUserRoleResource()
                    )
                        ->showOnExport()
                        ->sortable(),

                    Text::make('Фамилия', 'second_name')
                        ->showOnExport(),

                    Text::make(trans('moonshine::ui.resource.name'), 'name')
                        ->required()
                        ->showOnExport(),

                    Text::make('Отчество', 'last_name')
                        ->showOnExport(),

                    Email::make(trans('moonshine::ui.resource.email'), 'email')
                        ->sortable()
                        ->showOnExport()
                        ->required(),

                    BelongsTo::make(
                        'Организация',
                        'organization',
                        new OrganizationResource()
                    )
                        ->showOnExport()
                        ->sortable(),

                    Text::make('Номер телефона', 'phone')
                        ->hideOnIndex()
                        ->showOnExport(),

                    Text::make('Дополнительный номер телефона', 'phone_additional')
                        ->hideOnIndex()
                        ->showOnExport(),

                    Text::make('Должность', 'position')
                        ->hideOnIndex()
                        ->showOnExport(),

                    Image::make('Фото профиля', 'avatar')
                        ->hideOnIndex()
                        ->removable()
                        ->showOnExport()
                        ->disk('public')
                        ->dir('/avatars/' . auth('moonshine')->id())
                        ->keepOriginalFileName()
                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'tif']),

                    Date::make(trans('moonshine::ui.resource.created_at'), 'created_at')
                        ->format("d.m.Y")
                        ->default(now()->toDateTimeString())
                        ->sortable()
                        ->hideOnForm()
                        ->showOnExport(),

                    Block::make(trans('moonshine::ui.resource.change_password'), [
                        Password::make(trans('moonshine::ui.resource.password'), 'password')
                            ->customAttributes(['autocomplete' => 'new-password'])
                            ->hideOnIndex()
                            ->hideOnExport()
                            ->hideOnDetail(),

                        PasswordRepeat::make(trans('moonshine::ui.resource.repeat_password'), 'password_repeat')
                            ->customAttributes(['autocomplete' => 'confirm-password'])
                            ->hideOnIndex()
                            ->hideOnExport()
                            ->hideOnDetail(),
                    ]),

                    SwitchBoolean::make('Активность', 'active')
                        ->onValue(1)
                        ->offValue(0)
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

    protected function afterUpdated(Model $item)
    {
        if ($item->active !== 1) {
            $item->active = MoonshineUser::IS_ACTIVE;
            Mail::to($item->email)->send(new WelcomeMail($item));
            $item->save();
        }
    }
}
