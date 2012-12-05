<?php

namespace Knp\JsonSchemaBundle\Constraints;

use Symfony\Component\Validator\Constraint;
use Knp\JsonSchemaBundle\Model\Property;

class BlankConstraintHandler implements ConstraintHandlerInterface
{
    public function supports(Constraint $constraint)
    {
        return is_a($constraint, 'Symfony\Component\Validator\Constraints\Blank');
    }

    public function handle(Property $property, Constraint $constraint)
    {
        $property->setType('null');
    }
}
