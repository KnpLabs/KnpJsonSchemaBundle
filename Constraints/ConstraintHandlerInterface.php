<?php

namespace Knp\JsonSchemaBundle\Constraints;

use Symfony\Component\Validator\Constraint;
use Knp\JsonSchemaBundle\Model\Property;

interface ConstraintHandlerInterface
{
    public function supports(Constraint $constraint);
    public function handle(Property $property, Constraint $constraint);
}
