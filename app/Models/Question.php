<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class Question extends Model
{
    use HasFactory, HasMoonShineChangeLog;
}
