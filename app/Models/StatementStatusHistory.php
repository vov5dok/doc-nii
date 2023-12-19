<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatementStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'statement_id',
        'statement_status_id',
        'user_id',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(StatementStatus::class, 'statement_status_id', 'id');
    }
}
