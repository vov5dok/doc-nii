<?php

namespace App\Services\StatementService\Dtos;

use App\Services\StatementService\Dtos\Contracts\DtoWithFileContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class StatementRegisterDto implements DtoWithFileContract
{
    /**
     * @var array<UploadedFile>
     */
    public readonly array $files;
    public readonly array $validatedData;
    /**
     * @var array<int>|null
     */
    public readonly array $statementExperts;

    public function __construct(
        array $validatedData,
    )
    {
        $this->validatedData = $validatedData;
        $this->files = Arr::get($validatedData, 'file');
        $this->statementExperts = Arr::wrap(Arr::get($validatedData, 'statement_experts'));
    }
}
