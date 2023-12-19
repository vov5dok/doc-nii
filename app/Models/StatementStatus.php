<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class StatementStatus extends Model
{
    public const DEFAULT_STATUS_ID = 1;
    public const NEW = 1;
    public const CHANGED_BY_APPLICANT = 2;
    public const CHANGED_BY_EMPLOYEE = 3;
    public const UNDER_CONSIDERATION = 4;
    public const DECISION_HAS_BEEN_MADE = 5;
    public const TAKEN_INTO_CONSIDERATION = 6;
    public const COMPLETED = 7;
    use HasFactory, HasMoonShineChangeLog;

}
