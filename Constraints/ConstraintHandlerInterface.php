<?php

namespace Knp\JsonSchemaBundle\Constraints;

use Knp\JsonSchemaBundle\Model\Property;

interface ConstraintHandlerInterface
{
    public function supports($className, Property $property);
    public function handle($className, Property $property);
}
