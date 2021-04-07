<?php

namespace App\Validator;

use App\Service\User\Dto\Dto;
use Symfony\Component\Validator\ConstraintViolation;
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

    public function getErrors(bool $normalize = true): array
    {
        $normalized = [];
        /** @var ConstraintViolation $error */
        foreach ($this->errors as $error) {
            $normalized[$error->getPropertyPath()] = $error->getMessage();
        }

        return $normalized;
    }
}
