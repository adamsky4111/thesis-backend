<?php

namespace App\Validator;

use App\Service\User\Dto\Dto;

interface ValidatorInterface
{
    public function validate(Dto $dto);
    public function getErrors(bool $normalize = false): array;
}
