<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class StatementExpert extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    public function statements(): BelongsToMany
    {
        return $this->belongsToMany(Statement::class);
    }
}

