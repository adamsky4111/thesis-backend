<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class EmailValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Email) {
            throw new UnexpectedTypeException($constraint, Email::class);
        }

        $regex = '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

        if (!preg_match($regex, $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}
