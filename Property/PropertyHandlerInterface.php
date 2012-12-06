<?php

namespace Knp\JsonSchemaBundle\Property;

use Knp\JsonSchemaBundle\Model\Property;

interface PropertyHandlerInterface
{
    public function supports($className, Property $property);
    public function handle($className, Property $property);
}
