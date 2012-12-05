<?php

namespace Knp\JsonSchemaBundle\Schema;

use Knp\JsonSchemaBundle\Model\Schema;
use Knp\JsonSchemaBundle\Model\Property;
use Knp\JsonSchemaBundle\Constraints\PropertyHandlerInterface;

class SchemaBuilder
{
    private $name;
    private $properties;

    public function __construct()
    {
        $this->constraintHandlers = new \SplPriorityQueue;
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

        $this->applyConstraintHandlers($className, $property);

        $this->properties[] = $property;

        return $this;
    }

    public function getSchema()
    {
        return new Schema($this->name, $this->properties);
    }

    public function registerConstraintHandler(PropertyHandlerInterface $handler, $priority)
    {
        $this->constraintHandlers->insert($handler, $priority);
    }

    public function getConstraintHandlers()
    {
        return array_values(iterator_to_array(clone $this->constraintHandlers));
    }

    private function applyConstraintHandlers($className, Property $property)
    {
        foreach ($this->getConstraintHandlers() as $handler) {
            if ($handler->supports($className, $property)) {
                $handler->handle($className, $property);
            }
        }
    }
}
