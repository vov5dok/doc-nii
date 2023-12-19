<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;
use Ramsey\Uuid\Type\Integer;

class StatementFileType extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    public const DEFAULT = 'dokument-zaiavitelia';

    public const REGISTER ='dokument-o-registracii';

    public const DECIDE = 'dokument-o-priniatom-resenii';

    public const DECIDE_EXPERT = 'dokument-eksperta';


    protected $fillable = [
        'name',
        'code'
    ];

    public function statementFile(): HasOne
    {
        return $this->hasOne(StatementFile::class);
    }
}
