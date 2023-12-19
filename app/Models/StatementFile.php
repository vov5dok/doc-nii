<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\UploadedFile;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class StatementFile extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    protected $fillable = [
        'file',
        'name',
        'statement_id',
        'statement_file_type_id',
    ];

    public function statement(): BelongsTo
    {
        return $this->belongsTo(Statement::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(StatementFileType::class, 'statement_file_type_id');
    }

    public static function createFromFile(UploadedFile $file, int $statementID, string $code = StatementFileType::DEFAULT): void
    {
        StatementFile::create([
            'file'                   => $file->storeAs('public/statement_files', $statementID . '_' . $file->getClientOriginalName()),
            'name'                   => $file->getClientOriginalName() . '_' . $statementID,
            'statement_id'           => $statementID,
            'statement_file_type_id' => StatementFileType::firstWhere('code', $code)->id
        ]);
    }

    public static function deleteFile(int $fileID): void
    {
        $file = self::find($fileID);
        if ($file) {
            $file->delete();
        }
    }
}
