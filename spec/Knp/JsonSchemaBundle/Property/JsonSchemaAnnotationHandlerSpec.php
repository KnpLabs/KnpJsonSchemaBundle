<?php

namespace spec\Knp\JsonSchemaBundle\Property;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JsonSchemaAnnotationHandlerSpec extends ObjectBehavior
{
    /**
     * @param \Doctrine\Common\Annotations\Reader                $reader
     * @param \Knp\JsonSchemaBundle\Reflection\ReflectionFactory $reflectionFactory
     * @param \Knp\JsonSchemaBundle\Model\Property               $property
     * @param \ReflectionClass                                   $refClass
     * @param \ReflectionProperty                                $refProperty
     */
    function let($reader, $reflectionFactory, $property, $refClass, $refProperty)
    {
        $this->beConstructedWith($reader, $reflectionFactory);

        $reflectionFactory->create(Argument::any())->willReturn($refClass);
        $refClass->getProperty(Argument::any())->willReturn($refProperty);
    }

    /**
     * @param \Knp\JsonSchemaBundle\Annotations\ExclusiveMinimum $constraint
     */
    function it_sets_minimumExcluded_if_annotation_has_been_set($reader, $property, $refProperty, $constraint)
    {
        $reader->getPropertyAnnotations($refProperty)->willReturn(array($constraint));
        $property->getName()->shouldBeCalled();
        $property->setExclusiveMinimum(true)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param \Knp\JsonSchemaBundle\Annotations\ExclusiveMaximum $constraint
     */
    function it_sets_maximumExcluded_if_annotation_has_been_set($reader, $property, $refProperty, $constraint)
    {
        $reader->getPropertyAnnotations($refProperty)->willReturn(array($constraint));
        $property->getName()->shouldBeCalled();
        $property->setExclusiveMaximum(true)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param \Knp\JsonSchemaBundle\Annotations\Disallow $constraint
     */
    function it_sets_disallow_property_if_annotation_has_been_set($reader, $property, $refProperty, $constraint)
    {
        $reader->getPropertyAnnotations($refProperty)->willReturn(array($constraint));

        $disallowed             = array("boolean", "number", array("type" => "string", "format" => "email"));
        $constraint->disallowed = $disallowed;

        $property->getName()->shouldBeCalled();
        $property->setDisallowed($disallowed)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param \Knp\JsonSchemaBundle\Annotations\Type $constraint
     */
    function it_sets_type_if_annotation_has_been_set($reader, $property, $refProperty, $constraint)
    {
        $reader->getPropertyAnnotations($refProperty)->willReturn(array($constraint));

        $constraint->type = array('boolean', 'string');

        $property->getName()->shouldBeCalled();
        $property->setType(array('boolean', 'string'))->shouldBeCalled();

        $this->handle('some class', $property);
    }
}
