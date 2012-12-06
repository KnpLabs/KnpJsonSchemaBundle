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

    /**
     * @param Symfony\Component\Validator\Mapping\ClassMetadata $classMetadata
     * @param Symfony\Component\Validator\Mapping\PropertyMetadata $propertyMetadata
     * @param Symfony\Component\Validator\Constraints\Length $lengthConstraint
     * @param Knp\JsonSchemaBundle\Model\Property $property
     */
    function it_should_set_minimum_if_property_as_a_length_constraint_with_a_min_attribute($classMetadataFactory, $classMetadata, $propertyMetadata, $lengthConstraint, $property)
    {
        $propertyMetadata->name        = 'some property';
        $classMetadata->properties     = [$propertyMetadata];
        $propertyMetadata->constraints = [$lengthConstraint];
        $lengthConstraint->min         = 15;
        $classMetadataFactory->getClassMetadata('some class')->willReturn($classMetadata);
        $property->getName()->willReturn('some property');

        $property->setMinimum(15)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param Symfony\Component\Validator\Mapping\ClassMetadata $classMetadata
     * @param Symfony\Component\Validator\Mapping\PropertyMetadata $propertyMetadata
     * @param Symfony\Component\Validator\Constraints\Length $lengthConstraint
     * @param Knp\JsonSchemaBundle\Model\Property $property
     */
    function it_should_set_maximum_if_property_as_a_length_constraint_with_a_max_attribute($classMetadataFactory, $classMetadata, $propertyMetadata, $lengthConstraint, $property)
    {
        $propertyMetadata->name        = 'some property';
        $classMetadata->properties     = [$propertyMetadata];
        $propertyMetadata->constraints = [$lengthConstraint];
        $lengthConstraint->max         = 42;
        $classMetadataFactory->getClassMetadata('some class')->willReturn($classMetadata);
        $property->getName()->willReturn('some property');

        $property->setMaximum(42)->shouldBeCalled();

        $this->handle('some class', $property);
    }
}
