<?php

namespace App\Services\StatementService\Dtos;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class StatementDecideExpertDto
{
    /**
     * @var array<UploadedFile>
     */
    public readonly array $newFiles;
    /**
     * @var array<int>
     */
    public readonly array $deletingFiles;
    public readonly string $expertDecide;

    public function __construct(
        array $validatedData,
    )
    {
        $this->newFiles = Arr::get($validatedData, 'file');
        $this->deletingFiles = Arr::wrap(Arr::get($validatedData, 'delete_files'));
        $this->expertDecide = $validatedData['text'];
    }
}
