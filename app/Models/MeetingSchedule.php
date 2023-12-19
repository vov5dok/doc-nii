<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class MeetingSchedule extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    protected $fillable = ['id', 'sort', 'year'];

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class);
    }

    public static function getActionPageInfo(): array
    {
        $meetingsInfo = self::all()
            ->sortBy([['year', 'desc'], ['sort', 'asc'], ['id', 'desc']]) ?? false;
        return [
            'current_year' => $meetingsInfo->shift() ?? false,
            'past_years' => $meetingsInfo
        ];
    }
}
