<?php

namespace Knp\JsonSchemaBundle\Constraints;

use Knp\JsonSchemaBundle\Model\Property;

interface PropertyHandlerInterface
{
    public function supports($className, Property $property);
    public function handle($className, Property $property);
}
