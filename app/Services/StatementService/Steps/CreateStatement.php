<?php

namespace App\Services\StatementService\Steps;

use App\Models\Statement;
use App\Models\StatementStatus;
use App\Services\StatementService\Dtos\StatementCreateDto;
use App\Services\StatementService\Factories\StepsFactory;

class CreateStatement
{
    public function create(StatementCreateDto $statementDto, int $userId): StepsFactory
    {
        $statement = Statement::create([
            'name'                     => $statementDto->name,
            'comment'                  => $statementDto->comment,
            'current_procedure_id'     => $statementDto->current_procedure_id,
            'statement_status_id'      => StatementStatus::DEFAULT_STATUS_ID,
            'moonshine_user_id'        => $userId,
            'moonshine_user_update_id' => $userId,
        ]);

        return new StepsFactory($statement);
    }
}
