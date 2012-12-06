<?php

namespace spec\Knp\JsonSchemaBundle\Property;

use PHPSpec2\ObjectBehavior;

class CustomHandler extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Validator\Mapping\ClassMetadataFactoryInterface $classMetadataFactory
     */
    function let($classMetadataFactory)
    {
        $this->beConstructedWith($classMetadataFactory);
    }


    /**
     * @param Symfony\Component\Validator\Mapping\ClassMetadata $classMetadata
     * @param Symfony\Component\Validator\Mapping\PropertyMetadata $propertyMetadata
     * @param Symfony\Component\Validator\Constraints\Choice $choiceConstraint
     * @param Knp\JsonSchemaBundle\Model\Property $property
     */
    function it_should_set_enumeration_if_property_as_a_choice_constraint($classMetadataFactory, $classMetadata, $propertyMetadata, $choiceConstraint, $property)
    {
        $propertyMetadata->name        = 'some property';
        $classMetadata->properties     = [$propertyMetadata];
        $propertyMetadata->constraints = [$choiceConstraint];
        $choiceConstraint->choices     = ['foo', 'bar'];
        $classMetadataFactory->getClassMetadata('some class')->willReturn($classMetadata);
        $property->getName()->willReturn('some property');

        $property->setEnumeration(['foo', 'bar'])->shouldBeCalled();

        $this->handle('some class', $property);
    }
}
