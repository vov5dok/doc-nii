<?php

namespace App\Services\StatementService\Factories;

use App\Models\Statement;
use App\Services\StatementService\Dtos\StatementCreateDto;
use App\Services\StatementService\Steps\AddComment;
use App\Services\StatementService\Steps\AddExperts;
use App\Services\StatementService\Steps\AddFiles;
use App\Services\StatementService\Steps\DeleteFiles;
use Illuminate\Http\UploadedFile;

class StepsFactory
{
    public function __construct(
        private readonly Statement $statement,
    )
    {
    }

    /**
     * @param array<UploadedFile> $files
     * @param string $fileType
     * @return StepsFactory
     */
    public function addFiles(array $files, string $fileType): StepsFactory
    {
        return (new AddFiles($this->statement, $files))->execute($fileType);
    }

    public function addComment(StatementCreateDto $statementDto, int $userId): Statement
    {
        return (new AddComment($this->statement, $statementDto))->execute($userId);
    }

    /**
     * @param array<int> $statementExperts
     * @return StepsFactory
     */
    public function addExperts(array $statementExperts): StepsFactory
    {
        return (new AddExperts($this->statement))->execute($statementExperts);
    }

    public function deleteFiles(array $files): StepsFactory
    {
        return (new DeleteFiles($this->statement))->execute($files);
    }
}
