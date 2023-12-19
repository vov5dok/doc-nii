<?php

namespace App\Events\Contracts;

use App\Models\Statement;

/**
 * @property Statement $statement
 * @property int $userId
 */
interface StatementHistoryEvent
{
    public function __construct(
        Statement $statement,
        int       $userId,
    );
}
