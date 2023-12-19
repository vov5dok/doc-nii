<?php

namespace App\Services\StatementService\Steps;

use App\Models\Statement;
use App\Services\StatementService\Dtos\StatementCreateDto;
use App\Services\StatementService\Steps\Contracts\StepContract;

class AddComment implements StepContract
{
    public function __construct(
        private readonly Statement          $statement,
        private readonly StatementCreateDto $statementDto,
    )
    {
    }

    public function execute(int $userId): Statement
    {
        if (!empty($this->statementDto->comment)) {
            $this->statement->messages()->create([
                'message'           => $this->statementDto->comment,
                'date'              => now(),
                'moonshine_user_id' => $userId,
            ]);
        }
        return $this->statement;
    }
}
