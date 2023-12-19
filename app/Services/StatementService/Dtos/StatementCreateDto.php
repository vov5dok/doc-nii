<?php

namespace App\Services\StatementService\Dtos;

use App\Services\StatementService\Dtos\Contracts\DtoWithFileContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class StatementCreateDto implements DtoWithFileContract
{
    public readonly string $name;
    public readonly string $comment;
    public readonly int $current_procedure_id;
    /**
     * @var array<UploadedFile> $files
     */
    public array $files;

    public function __construct(
        array $validatedData
    )
    {
        $this->name = Str::wrap(Arr::get($validatedData, 'name', ''), '');
        $this->comment = Str::wrap(Arr::get($validatedData, 'comment'), '');
        $this->current_procedure_id = Arr::get($validatedData, 'current_procedure_id');
        $this->files = Arr::get($validatedData, 'file');
    }
}
