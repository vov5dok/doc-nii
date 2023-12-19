<?php

namespace App\Listeners;

use App\Events\Contracts\StatementHistoryEvent;
use App\Events\StatementCreated;
use App\Models\StatementStatusHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStatementHistory
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param StatementHistoryEvent $event
     * @return void
     */
    public function handle(StatementHistoryEvent $event): void
    {
        StatementStatusHistory::create([
            'statement_id'        => $event->statement->id,
            'statement_status_id' => $event->statement->statementStatus->id,
            'user_id'             => $event->userId,
        ]);
    }
}
