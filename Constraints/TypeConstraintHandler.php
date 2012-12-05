<?php

namespace Knp\JsonSchemaBundle\Constraints;

use Symfony\Component\Validator\Constraint;
use Knp\JsonSchemaBundle\Model\Property;

class TypeConstraintHandler implements ConstraintHandlerInterface
{
    public function supports(Constraint $constraint)
    {
        return is_a($constraint, 'Symfony\Component\Validator\Constraints\Type');
    }

    public function handle(Property $property, Constraint $constraint)
    {
        switch ($constraint->type) {
            case 'text':
                $property->setType('string');
                break;
            case 'float':
                $property->setType('number');
                break;
            case 'integer':
                $property->setType('integer');
                break;
            case 'boolean':
                $property->setType('boolean');
                break;
        }
    }
}
