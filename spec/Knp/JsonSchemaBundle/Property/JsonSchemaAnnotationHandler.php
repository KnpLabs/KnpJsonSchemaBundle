<?php

namespace spec\Knp\JsonSchemaBundle\Property;

use Knp\JsonSchemaBundle\Model\Property;

use PHPSpec2\ObjectBehavior;

class JsonSchemaAnnotationHandler extends ObjectBehavior
{
    /**
     * @param Doctrine\Common\Annotations\Reader $reader
     * @param Knp\JsonSchemaBundle\Schema\ReflectionFactory $reflectionFactory
     * @param Knp\JsonSchemaBundle\Model\Property $property
     * @param ReflectionClass $refClass
     * @param ReflectionProperty $refProperty
     */
    function let($reader, $reflectionFactory, $property, $refClass, $refProperty)
    {
        $this->beConstructedWith($reader, $reflectionFactory);

        $reflectionFactory->create(ANY_ARGUMENT)->willReturn($refClass);
    }

    /**
     * @param Knp\JsonSchemaBundle\Annotations\ExclusiveMinimum $constraint
     */
    function it_should_set_minimumExcluded_if_annotation_has_been_set($reader, $property, $refClass, $refProperty, $constraint)
    {
        $property->getName()->willReturn('a property');
        $refClass->getProperty('a property')->willReturn($refProperty);
        $reader->getPropertyAnnotations($refProperty)->willReturn([$constraint]);

        $property->setExclusiveMinimum(true)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param Knp\JsonSchemaBundle\Annotations\ExclusiveMaximum $constraint
     */
    function it_should_set_maximumExcluded_if_annotation_has_been_set($reader, $property, $refClass, $refProperty, $constraint)
    {
        $property->getName()->willReturn('a property');
        $refClass->getProperty('a property')->willReturn($refProperty);
        $reader->getPropertyAnnotations($refProperty)->willReturn([$constraint]);

        $property->setExclusiveMaximum(true)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param Knp\JsonSchemaBundle\Annotations\Disallow $constraint
     */
    function it_should_set_disallow_property_if_annotation_has_been_set($reader, $property, $refClass, $refProperty, $constraint)
    {
        $property->getName()->willReturn('a property');
        $refClass->getProperty('a property')->willReturn($refProperty);
        $reader->getPropertyAnnotations($refProperty)->willReturn([$constraint]);

        $disallowed             = ["boolean", "number", ["type" => "string", "format" => "email"]];
        $constraint->disallowed = $disallowed;

        $property->setDisallowed($disallowed)->shouldBeCalled();

        $this->handle('some class', $property);
    }
}
