<?php

namespace App\Models;

use App\Http\Requests\UpdateStatementRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class Statement extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    protected $fillable = [
        'name',
        'comment',
        'current_procedure_id',
        'statement_status_id',
        'moonshine_user_id',
        'moonshine_user_update_id',
    ];

    public function currentProcedure(): BelongsTo
    {
        return $this->belongsTo(Procedure::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(StatementFile::class);
    }

    public function statementStatus(): BelongsTo
    {
        return $this->belongsTo(StatementStatus::class);
    }

    public function moonshineUser(): BelongsTo
    {
        return $this->belongsTo(MoonshineUser::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function experts(): BelongsToMany
    {
        return $this->belongsToMany(
            MoonshineUser::class,
            'expert_statement',
            'statement_id',
            'expert_id'
        );
    }

    public function moonshineUserUpdate(): BelongsTo
    {
        return $this->belongsTo(
            MoonshineUser::class,
            'moonshine_user_update_id'
        );
    }

    public function expertOpinions(): HasMany
    {
        return $this->hasMany(ExpertOpinion::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(StatementStatusHistory::class);
    }

    public static function filterByStatus($query, $statuses)
    {
        return $query->whereIn('statement_status_id', function ($q) use ($statuses) {
            $q->select('id')
                ->from('statement_statuses')
                ->whereIn('code', $statuses);
        });
    }

    public static function sortBy($query, $sort)
    {
        return match ($sort) {
            'name' => $query->orderBy('name'),
            'status' => $query->join('statement_statuses', 'statement_statuses.id', '=', 'statements.statement_status_id')
                ->select('statements.*')
                ->orderBy('statement_statuses.code'),
            'changed_date' => $query->orderBy('status_changed_at', 'desc'),
            'permission_date' => $query->orderBy('completed_at', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };
    }

    public static function forUser($user)
    {
        $query = static::query();

        if ($user->hasAnyRole(['applicant'])) {
            $query->where('moonshine_user_id', $user->id);
        }

        if ($user->hasAnyRole(['participant'])) {
            $query->whereHas('experts', function ($query) use ($user) {
                $query->where('expert_id', $user->id);
            });
        }

        return $query;
    }

    public function updateFromRequest(UpdateStatementRequest $request): bool
    {
//        TODO допилить и удалить метод
        $this->comment = $request->comment ?? $this->comment;

        if (!empty($request->delete_files)) {
            $this->deleteFiles($request->delete_files);
        }

        $statementExpertsIDs = $request->statement_experts;
        $this->experts()->attach($statementExpertsIDs);
        $this->addFiles($request->reg_files ?? [], StatementFileType::REGISTER);
        if (!empty($request->reg_delete_files)) {
            $this->deleteFiles($request->reg_delete_files);
        }
        $this->addFiles($request->dec_files ?? [], StatementFileType::DECIDE);
        if (!empty($request->dec_delete_files)) {
            $this->deleteFiles($request->dec_delete_files);
        }
        $sessionDate = $request->session_date;
        if (!empty($sessionDate)) {
            $this->session_date = $sessionDate;
        }
        $this->registration_date = $request->registration_date;
        $this->registration_number = $request->registration_number;

        $this->moonshine_user_update_id = auth('moonshine')->user()->id;
        return $this->save();
    }

    public function addFiles(array $files, string $fileTypeCode = StatementFileType::DEFAULT): bool
    {
        foreach ($files as $file) {
            if (!is_null($file)) {
                StatementFile::createFromFile($file, $this->id, $fileTypeCode);
            }
        }
        return true;
    }

    public function deleteFiles(array $fileIds): void
    {
        DB::table('statement_files')
            ->whereIn('id', $fileIds)
            ->delete();
    }

    public function hasAnyStatus(array $statementStatuses): bool
    {
        return in_array($this->statementStatus->code, $statementStatuses);
    }
}
