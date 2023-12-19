<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class LegalManual extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    protected $fillable = ['id', 'sort', 'content', 'added_at'];

    public function files(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function seoSetting(): HasOne
    {
        return $this->hasOne(SeoSetting::class);
    }

}
