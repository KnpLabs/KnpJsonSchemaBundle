<?php

namespace Knp\JsonSchemaBundle\Constraints;

use Symfony\Component\Validator\Constraint;
use Knp\JsonSchemaBundle\Model\Property;

class NotBlankConstraintHandler implements ConstraintHandlerInterface
{
    public function supports(Constraint $constraint)
    {
        return is_a($constraint, 'Symfony\Component\Validator\Constraints\NotBlank');
    }

    public function handle(Property $property, Constraint $constraint)
    {
        $property->setRequired(true);
    }
}
