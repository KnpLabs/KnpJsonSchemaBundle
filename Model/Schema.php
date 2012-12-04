<?php

namespace Knp\JsonSchemaBundle\Model;

class Schema implements \JsonSerializable
{
    private $name;
    private $properties;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function addProperty(Property $property)
    {
        $this->properties[$property->getName()] = $property;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'properties' => $this->properties,
        ];
    }
}
