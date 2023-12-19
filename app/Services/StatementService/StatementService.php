<?php

namespace App\Services\StatementService;

use App\Events\StatementCompleted;
use App\Events\StatementCreated;
use App\Events\StatementDecided;
use App\Events\StatementRegistered;
use App\Models\Statement;
use App\Models\StatementFileType;
use App\Models\StatementStatus;
use App\Services\StatementService\Dtos\StatementCreateDto;
use App\Services\StatementService\Dtos\StatementDecideExpertDto;
use App\Services\StatementService\Dtos\StatementRegisterDto;
use App\Services\StatementService\Steps\ChangeExpertOpinion;
use App\Services\StatementService\Steps\UpdateStatementStatus;
use App\Services\StatementService\Steps\RegisterStatement;
use App\Services\StatementService\Steps\CreateStatement;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class StatementService
{
    public function __construct(
        private readonly CreateStatement       $createStatement,
        private readonly RegisterStatement     $registerStatement,
        private readonly UpdateStatementStatus $updateStatementStatus,
        private readonly ChangeExpertOpinion   $changeExpertOpinion,
    )
    {
    }

    public function create(StatementCreateDto $statementDto, int $userId): void
    {
        $statement = DB::transaction(function () use ($statementDto, $userId) {
            return $this->createStatement
                ->create($statementDto, $userId)
                ->addFiles($statementDto->files, StatementFileType::DEFAULT)
                ->addComment($statementDto, $userId);
        });
        event(new StatementCreated($statement, $userId));
    }

    public function register(Statement $statement, int $userId, StatementRegisterDto $dto): void
    {
        DB::transaction(function () use ($statement, $dto) {
            $this->registerStatement
                ->register($statement, $dto->validatedData)
                ->addFiles($dto->files, StatementFileType::REGISTER)
                ->addExperts($dto->statementExperts);
        });
        event(new StatementRegistered($statement, $userId));
    }

    public function complete(Statement $statement, int $userId): void
    {
        $this->updateStatementStatus
            ->update($statement, StatementStatus::COMPLETED);

        event(new StatementCompleted($statement, $userId));
    }

    /**
     * @param Statement $statement
     * @param int $userId
     * @param array<UploadedFile> $files
     * @return void
     */
    public function decide(Statement $statement, int $userId, array $files): void
    {
        DB::transaction(function () use ($statement, $files) {
            $this->updateStatementStatus
                ->update($statement, StatementStatus::COMPLETED)
                ->addFiles($files, StatementFileType::DECIDE);
        });

        event(new StatementDecided($statement, $userId));
    }

    public function decideExpert(Statement $statement, int $userId, StatementDecideExpertDto $dto): void
    {
        DB::transaction(function () use ($statement, $userId, $dto) {
            $this->changeExpertOpinion
                ->change($statement, $userId, $dto->expertDecide)
                ->deleteFiles($dto->deletingFiles)
                ->addFiles($dto->newFiles, StatementFileType::DECIDE_EXPERT);
        });
    }
}
