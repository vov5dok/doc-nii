<?php

namespace App\Services\StatementService\Factories;

use App\Services\StatementService\Dtos\StatementCreateDto;
use App\Services\StatementService\Dtos\StatementDecideExpertDto;
use App\Services\StatementService\Dtos\StatementRegisterDto;

class DtoFactory
{
    public function statementCreateDto(array $validatedData): StatementCreateDto
    {
        return new StatementCreateDto($validatedData);
    }

    public function statementRegisterDto(array $validatedData): StatementRegisterDto
    {
        return new StatementRegisterDto($validatedData);
    }

    public function statementDecideExpertDto(array $validatedData): StatementDecideExpertDto
    {
        return new StatementDecideExpertDto($validatedData);
    }
}
