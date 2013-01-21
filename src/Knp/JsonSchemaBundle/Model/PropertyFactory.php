<?php

namespace Knp\JsonSchemaBundle\Model;

class PropertyFactory
{
    public function createProperty($name)
    {
        $property = new Property();
        $property->setName($name);

        return $property;
    }
}
