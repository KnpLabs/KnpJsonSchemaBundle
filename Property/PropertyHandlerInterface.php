<?php

namespace Knp\JsonSchemaBundle\Property;

use Knp\JsonSchemaBundle\Model\Property;

interface PropertyHandlerInterface
{
    public function handle($className, Property $property);
}
