<?php

namespace Knp\JsonSchemaBundle\Schema;

use Symfony\Component\Validator\Mapping\PropertyMetadata;
use Symfony\Component\Validator\Constraint;
use Knp\JsonSchemaBundle\Model\Schema;
use Knp\JsonSchemaBundle\Model\Property;
use Knp\JsonSchemaBundle\Constraints\ConstraintHandlerInterface;

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

    public function addProperty(PropertyMetadata $propertyMetadata)
    {
        $property = new Property();
        $property->setName($propertyMetadata->name);

        foreach ($propertyMetadata->constraints as $constraint) {
            $this->applyConstraintHandlers($property, $constraint);
        }

        $this->properties[] = $property;

        return $this;
    }

    public function getSchema()
    {
        return new Schema($this->name, $this->properties);
    }

    public function registerConstraintHandler(ConstraintHandlerInterface $handler, $priority)
    {
        $this->constraintHandlers->insert($handler, $priority);
    }

    public function getConstraintHandlers()
    {
        return array_values(iterator_to_array(clone $this->constraintHandlers));
    }

    private function applyConstraintHandlers(Property $property, Constraint $constraint)
    {
        foreach ($this->getConstraintHandlers() as $handler) {
            if ($handler->supports($constraint)) {
                $handler->handle($property, $constraint);
            }
        }
    }
}
