<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PrimeVerifier extends ConstraintValidator
{

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * PrimeVerifier constructor.
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\Prime */

        if (null === $value || '' === $value) {
            return;
        }

        if (!in_array($value, [1, 2, 3, 5, 7, 11, 13, 17])) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
