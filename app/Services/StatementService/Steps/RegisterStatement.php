<?php

namespace App\Services\StatementService\Steps;

use App\Models\Statement;
use App\Services\StatementService\Factories\DtoFactory;
use App\Services\StatementService\Factories\StepsFactory;

class RegisterStatement
{
    public function register(Statement $statement, array $validatedData): StepsFactory
    {
        $statement->update($validatedData);

        return new StepsFactory($statement);
    }
}
