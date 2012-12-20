<?php

namespace Knp\JsonSchemaBundle\Model;

class Schema implements \JsonSerializable
{
    private $title;
    private $properties;

    public function __construct($title = null, array $properties = array())
    {
        $this->setTitle($title);
        foreach ($properties as $property) {
            $this->addProperty($property);
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
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
            'title' => $this->title,
            'properties' => $this->properties,
        ];
    }
}
