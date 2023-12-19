<?php

namespace App\Services\StatementService\Steps;

use App\Models\Statement;
use App\Services\StatementService\Factories\StepsFactory;

class ChangeExpertOpinion
{
    public function change(Statement $statement, int $userId, string $expertDecide): StepsFactory
    {
        $statement->expertOpinions()->firstOrCreate([
            'moonshine_user_id' => $userId,
        ], [
            'text'              => $expertDecide,
            'moonshine_user_id' => $userId,
        ]);

        return new StepsFactory($statement);
    }
}
