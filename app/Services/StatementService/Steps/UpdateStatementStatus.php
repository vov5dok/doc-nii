<?php

namespace App\Services\StatementService\Steps;

use App\Models\Statement;
use App\Services\StatementService\Factories\StepsFactory;

class UpdateStatementStatus
{
    public function update(Statement $statement, string $status): StepsFactory
    {
        $statement->update([
            'statement_status_id' => $status
        ]);

        return new StepsFactory($statement);
    }
}
