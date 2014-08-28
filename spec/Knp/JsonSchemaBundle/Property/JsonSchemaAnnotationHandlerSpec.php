<?php

namespace spec\Knp\JsonSchemaBundle\Property;

use Knp\JsonSchemaBundle\Model\Property;

use PhpSpec\ObjectBehavior;

class JsonSchemaAnnotationHandlerSpec extends ObjectBehavior
{
    /**
     * @param Doctrine\Common\Annotations\Reader                $reader
     * @param Knp\JsonSchemaBundle\Reflection\ReflectionFactory $reflectionFactory
     * @param Knp\JsonSchemaBundle\Model\Property               $property
     * @param ReflectionClass                                   $refClass
     * @param ReflectionProperty                                $refProperty
     */
    function let($reader, $reflectionFactory, $property, $refClass, $refProperty)
    {
        $this->beConstructedWith($reader, $reflectionFactory);

        $reflectionFactory->create(\Prophecy\Argument::any())->willReturn($refClass);
        $refClass->getProperty(\Prophecy\Argument::any())->willReturn($refProperty);
    }

    /**
     * @param Knp\JsonSchemaBundle\Annotations\ExclusiveMinimum $constraint
     */
    function it_should_set_minimumExcluded_if_annotation_has_been_set($reader, $property, $refProperty, $constraint)
    {
        $reader->getPropertyAnnotations($refProperty)->willReturn([$constraint]);
        $property->setExclusiveMinimum(true)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param Knp\JsonSchemaBundle\Annotations\ExclusiveMaximum $constraint
     */
    function it_should_set_maximumExcluded_if_annotation_has_been_set($reader, $property, $refProperty, $constraint)
    {
        $reader->getPropertyAnnotations($refProperty)->willReturn([$constraint]);
        $property->setExclusiveMaximum(true)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param Knp\JsonSchemaBundle\Annotations\Disallow $constraint
     */
    function it_should_set_disallow_property_if_annotation_has_been_set($reader, $property, $refProperty, $constraint)
    {
        $reader->getPropertyAnnotations($refProperty)->willReturn([$constraint]);

        $disallowed             = ["boolean", "number", ["type" => "string", "format" => "email"]];
        $constraint->disallowed = $disallowed;

        $property->setDisallowed($disallowed)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param Knp\JsonSchemaBundle\Annotations\Type $constraint
     */
    function it_should_set_type_if_annotation_has_been_set($reader, $property, $refProperty, $constraint)
    {
        $reader->getPropertyAnnotations($refProperty)->willReturn([$constraint]);

        $types             = ['boolean', 'string'];
        $constraint->types = $types;

        $property->addType('boolean')->shouldBeCalled();
        $property->addType('string')->shouldBeCalled();

        $this->handle('some class', $property);
    }
}
