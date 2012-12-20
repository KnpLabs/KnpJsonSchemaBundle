<?php

namespace Knp\JsonSchemaBundle\Schema;

use Knp\JsonSchemaBundle\Model\Schema;
use Knp\JsonSchemaBundle\Model\Property;
use Knp\JsonSchemaBundle\Property\PropertyHandlerInterface;

class SchemaBuilder
{
    private $name;
    private $properties;
    private $propertyHandlers;

    public function __construct()
    {
        $this->propertyHandlers = new \SplPriorityQueue;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function addProperty($className, $propertyName)
    {
        $property = new Property();
        $property->setName($propertyName);

        $this->applyPropertyHandlers($className, $property);

        $this->properties[] = $property;

        return $this;
    }

    public function getSchema()
    {
        return new Schema($this->name, $this->properties);
    }

    public function registerPropertyHandler(PropertyHandlerInterface $handler, $priority)
    {
        $this->propertyHandlers->insert($handler, $priority);
    }

    public function getPropertyHandlers()
    {
        return array_values(iterator_to_array(clone $this->propertyHandlers));
    }

    private function applyPropertyHandlers($className, Property $property)
    {
        foreach ($this->getPropertyHandlers() as $handler) {
            $handler->handle($className, $property);
        }
    }
}
