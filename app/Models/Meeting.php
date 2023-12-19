<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class Meeting extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    protected $fillable = ['sort', 'meeting_schedules_id', 'meeting_date', 'meeting_date_correct'];

}
