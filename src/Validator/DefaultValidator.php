<?php

namespace App\Validator;

use App\Service\User\Dto\Dto;
use Symfony\Component\Validator\Validator\ValidatorInterface as BaseValidator;

final class DefaultValidator implements ValidatorInterface
{
    protected iterable $errors;

    public function __construct(
        protected BaseValidator $validator,
    ) {}

    public function validate(Dto $dto): bool
    {
        $this->errors = $this->validator->validate($dto);

        return (count($this->errors) > 0);
    }

    public function getErrors(bool $normalize = false): string|array
    {
        return ($normalize) ? (string) $this->errors : $this->errors;
    }
}
