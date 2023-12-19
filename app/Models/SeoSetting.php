<?php

namespace App\Models;

use App\Http\Controllers\LegalManualController;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class SeoSetting extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    protected $fillable = ['id', 'slug', 'description', 'keywords', 'post_id'];

    /**
     * @param string $slug
     * @return void
     */
    public static function generateStaticPageSeo(string $slug)
    {
        $seoSettings = self::where('slug', '=', $slug)
            ->orderBy('id', 'desc')
            ->first();

        if (!empty($seoSettings)) {
            self::generateSEO($seoSettings);
        }
    }

    /**
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function legal_manual(): BelongsTo
    {
        return $this->belongsTo(LegalManual::class);
    }

    /**
     * @param Model $model
     * @param string $title
     * @return void
     */
    public static function generateSEO(Model $model, string $title = ''): void
    {
        SEOMeta::setTitle($title !== '' ? $title : $model->title, false);
        SEOMeta::setDescription($model->description);
        SEOMeta::setKeywords($model->keywords);
    }

}
