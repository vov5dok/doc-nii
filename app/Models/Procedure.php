<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class Procedure extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    protected $fillable = [
        'name',
        'code',
    ];


    public static function getIdByCode(string $code): int
    {
        if ($code === '') {
            return 0;
        }
        return self::where('code', $code)
            ->firstOrFail()
            ->id;
    }

    public function statements(): HasMany
    {
        return $this->hasMany(Statement::class);
    }
}
