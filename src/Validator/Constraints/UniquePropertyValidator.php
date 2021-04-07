<?php
namespace App\Validator\Constraints;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniquePropertyValidator extends ConstraintValidator
{
    public function __construct(
        protected EntityManagerInterface $em,
    ) {}

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueProperty) {
            throw new UnexpectedTypeException($constraint, UniqueProperty::class);
        }
        $repo = $this->em->getRepository($constraint->className);

        $object = $repo->findBy([$constraint->propertyName => $value]);
        if (!empty($object)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->setParameter('{{ property }}', $constraint->propertyName)
                ->addViolation();
        }
    }

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}
