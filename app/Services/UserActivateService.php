<?php

namespace App\Services;

use App\Events\UserActivated;
use App\Models\MoonshineUser;
use Illuminate\Database\Eloquent\Builder;

class UserActivateService
{
    public function activate(int|array|null $id = null): void
    {
        MoonshineUser::when(null !== $id, function (Builder $query) use ($id){
            $query->whereIn('id', (array)$id)->activate();
        });
        event(new UserActivated($id));
    }
}
