<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Leeto\MoonShine\Traits\Models\HasMoonShineChangeLog;

class Message extends Model
{
    use HasFactory, HasMoonShineChangeLog;

    protected $fillable = ['message', 'date', 'moonshine_user_id', 'statement_id'];

    public function moonshineUser(): BelongsTo
    {
        return $this->belongsTo(MoonshineUser::class);
    }

    public function statement(): BelongsTo
    {
        return $this->belongsTo(Statement::class);
    }

    public static function addMessage(string $text, Statement $statement): bool
    {
        if (empty($text)) {
            return false;
        }
        $message = new Message;
        $message->message = $text;
        $message->date = date('Y-m-d H:i:s');
        $message->moonshine_user_id = auth('moonshine')->user()->id;
        $message->statement_id = $statement->id;
        return $message->save();
    }
}
