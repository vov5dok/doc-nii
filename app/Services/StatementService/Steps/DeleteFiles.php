<?php

namespace App\Services\StatementService\Steps;

use App\Models\Statement;
use App\Services\StatementService\Factories\StepsFactory;
use Illuminate\Support\Arr;

class DeleteFiles
{
    public function __construct(
        private readonly Statement $statement
    )
    {
    }

    /**
     * @param array<int> $files
     * @return StepsFactory
     */
    public function execute(array $files): StepsFactory
    {
        if (!empty($files)){
            $this->statement->files()->whereIn('id', $files)->delete();
        }

        return new StepsFactory($this->statement);
    }
}
