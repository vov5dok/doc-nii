<?php

namespace App\Services\StatementService\Steps;

use App\Models\Statement;
use App\Models\StatementFileType;
use App\Services\StatementService\Factories\StepsFactory;
use Illuminate\Http\UploadedFile;

/**
 * @private array<UploadedFile> $files
 */
class AddFiles
{
    public function __construct(
        private readonly Statement $statement,
        private readonly array     $files,
    )
    {
    }

    public function execute(string $statementFileType): StepsFactory
    {
        collect($this->files)->each(function (UploadedFile $file) use ($statementFileType) {
            $this->statement->files()->create([
                'file'                   => $file->storeAs('public/statement_files', $this->statement->id . '_' . $file->getClientOriginalName()),
                'name'                   => $file->getClientOriginalName() . '_' . $this->statement->id,
                'statement_file_type_id' => StatementFileType::firstWhere('code', $statementFileType)->id
            ]);
        });
        return new StepsFactory($this->statement);
    }
}
