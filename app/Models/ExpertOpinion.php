<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class ExpertOpinion extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    protected $fillable = [
        'moonshine_user_id',
    ];
    public function moonshineUser()
    {
        return $this->belongsTo(MoonshineUser::class);
    }

    public function statement()
    {
        return $this->belongsTo(Statement::class);
    }
}
