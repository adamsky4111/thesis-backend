<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Email extends Constraint
{
    public string $message = 'validator.error.email.wrong_format';

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}
