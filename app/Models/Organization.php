<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class Organization extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    protected $fillable = [
        'name'
    ];

//    public function moonshineUsers(): HasMany
//    {
//        return $this->hasMany(MoonshineUser::class);
//    }
}
