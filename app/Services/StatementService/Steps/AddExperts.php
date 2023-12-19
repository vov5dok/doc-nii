<?php

namespace App\Services\StatementService\Steps;

use App\Models\Statement;
use App\Services\StatementService\Factories\StepsFactory;

class AddExperts
{
    public function __construct(
        private readonly Statement $statement,
    )
    {
    }

    /**
     * @param array<int> $statementExperts
     * @return StepsFactory
     */
    public function execute(array $statementExperts): StepsFactory
    {
        $this->statement->experts()->attach($statementExperts);
        return new StepsFactory($this->statement);
    }
}
