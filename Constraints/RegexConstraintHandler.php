<?php

namespace Knp\JsonSchemaBundle\Constraints;

use Symfony\Component\Validator\Constraint;
use Knp\JsonSchemaBundle\Model\Property;

class RegexConstraintHandler implements ConstraintHandlerInterface
{
    public function supports(Constraint $constraint)
    {
        return is_a($constraint, 'Symfony\Component\Validator\Constraints\Regex');
    }

    public function handle(Property $property, Constraint $constraint)
    {
        $property->setPattern($constraint->pattern);
    }
}
