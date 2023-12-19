<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class ApplicationDocument extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    protected $fillable = ['id', 'name', 'file', 'legal_manual_id'];

    public function legalManual(): BelongsTo
    {
        return $this->belongsTo(LegalManual::class);
    }

}
