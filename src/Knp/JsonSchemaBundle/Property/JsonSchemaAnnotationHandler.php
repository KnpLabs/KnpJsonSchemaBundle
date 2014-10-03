<?php

namespace Knp\JsonSchemaBundle\Property;

use Knp\JsonSchemaBundle\Model\Property;
use Knp\JsonSchemaBundle\Reflection\ReflectionFactory;
use Doctrine\Common\Annotations\Reader;

class JsonSchemaAnnotationHandler implements PropertyHandlerInterface
{
    private $reader;
    private $reflectionFactory;

    public function __construct(Reader $reader, ReflectionFactory $reflectionFactory)
    {
        $this->reader = $reader;
        $this->reflectionFactory = $reflectionFactory;
    }

    public function handle($className, Property $property)
    {
        foreach ($this->getJsonSchemaConstraintsForProperty($className, $property) as $constraint) {
            if ($constraint instanceof \Knp\JsonSchemaBundle\Annotations\Minimum) {
                $property->setMinimum($constraint->minimum);
            }
            if ($constraint instanceof \Knp\JsonSchemaBundle\Annotations\ExclusiveMinimum) {
                $property->setExclusiveMinimum(true);
            }
            if ($constraint instanceof \Knp\JsonSchemaBundle\Annotations\Maximum) {
                $property->setMaximum($constraint->maximum);
            }
            if ($constraint instanceof \Knp\JsonSchemaBundle\Annotations\ExclusiveMaximum) {
                $property->setExclusiveMaximum(true);
            }
            if ($constraint instanceof \Knp\JsonSchemaBundle\Annotations\Disallow) {
                $property->setDisallowed($constraint->disallowed);
            }
            if ($constraint instanceof \Knp\JsonSchemaBundle\Annotations\Type) {
                $types = (array) $constraint->type;
                $property->setType($types);
            }
            if ($constraint instanceof \Knp\JsonSchemaBundle\Annotations\Title) {
                $property->setTitle($constraint->name);
            }
            if ($constraint instanceof \Knp\JsonSchemaBundle\Annotations\Description) {
                $property->setDescription($constraint->name);
            }
            if ($constraint instanceof \Knp\JsonSchemaBundle\Annotations\Format) {
                $property->setFormat($constraint->format);
            }
            if ($constraint instanceof \Knp\JsonSchemaBundle\Annotations\Options) {
                $property->setOptions($constraint->options);
            }
            if ($constraint instanceof \Knp\JsonSchemaBundle\Annotations\Enum) {
                $property->setEnum($constraint->enum);
            }
            if ($constraint instanceof \Knp\JsonSchemaBundle\Annotations\Ignore) {
                $property->setIgnored(true);
            }
            if ($constraint instanceof \Knp\JsonSchemaBundle\Annotations\Object) {
                $property->setObject($constraint->alias);
                $property->setMultiple($constraint->multiple);
            }
        }
    }

    private function getJsonSchemaConstraintsForProperty($className, Property $property)
    {
        $refClass = $this->reflectionFactory->create($className);

        return $this->reader->getPropertyAnnotations($refClass->getProperty($property->getName()));
    }
}
