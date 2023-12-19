<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class Post extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    protected $fillable = [
        'id',
        'active',
        'name',
        'image',
        'preview',
        'detail_text',
        'slug'
    ];

    public static function getFirstPage()
    {
        return self::where('active', '=', 1)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', 1);
    }

    public static function getCountPosts()
    {
        return self::all('id')
            ->count();
    }

    public function seoSetting(): HasOne
    {
        return $this->hasOne(SeoSetting::class);
    }

}
