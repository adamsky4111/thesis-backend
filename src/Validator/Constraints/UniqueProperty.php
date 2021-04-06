<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueProperty extends Constraint
{
    public string $message = 'validator.error.generic.already_exist';

    public string $className = '';

    public string $propertyName = '';

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}
