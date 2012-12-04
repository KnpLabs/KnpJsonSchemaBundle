<?php

namespace Knp\JsonSchemaBundle\Schema;

use Symfony\Component\Validator\Mapping\PropertyMetadata;
use Knp\JsonSchemaBundle\Model\Schema;
use Knp\JsonSchemaBundle\Model\Property;

class SchemaBuilder
{
    private $name;
    private $properties;

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function addProperty(PropertyMetadata $propertyMetadata)
    {
        $property = new Property();
        $property->setName($propertyMetadata->name);

        foreach ($propertyMetadata->constraints as $constraint) {
            $property->addConstraint($constraint);
        }

        $this->properties[] = $property;

        return $this;
    }

    public function getSchema()
    {
        return new Schema($this->name, $this->properties);
    }
}
