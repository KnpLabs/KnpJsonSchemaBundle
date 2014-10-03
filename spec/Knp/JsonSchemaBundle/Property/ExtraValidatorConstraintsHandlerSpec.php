<?php

namespace spec\Knp\JsonSchemaBundle\Property;

use Knp\JsonSchemaBundle\Model\Property;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExtraValidatorConstraintsHandlerSpec extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Validator\MetadataFactoryInterface $classMetadataFactory
     * @param Symfony\Component\Validator\Mapping\ClassMetadata $classMetadata
     * @param Symfony\Component\Validator\Mapping\PropertyMetadata $propertyMetadata
     * @param Knp\JsonSchemaBundle\Model\Property $property
     */
    function let($classMetadataFactory, $classMetadata, $propertyMetadata, $property)
    {
        $this->beConstructedWith($classMetadataFactory);
        $propertyMetadata->name    = 'some property';
        $classMetadata->properties = [$propertyMetadata];
        $classMetadataFactory->getMetadataFor(Argument::any())->willReturn($classMetadata);
        $property->getName()->willReturn('some property');
    }

    /**
     * @param Symfony\Component\Validator\Constraints\Choice $choiceConstraint
     */
    function it_should_set_enumeration_if_property_as_a_choice_constraint($classMetadataFactory, $classMetadata, $propertyMetadata, $property, $choiceConstraint)
    {
        $propertyMetadata->constraints = [$choiceConstraint];
        $choiceConstraint->choices     = ['foo', 'bar'];

        $property->setEnumeration(['foo', 'bar'])->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param Symfony\Component\Validator\Constraints\Length $lengthConstraint
     */
    function it_should_set_minimum_if_property_as_a_length_constraint_with_a_min_attribute($classMetadataFactory, $classMetadata, $propertyMetadata, $property, $lengthConstraint)
    {
        $propertyMetadata->constraints = [$lengthConstraint];
        $lengthConstraint->min         = 15;

        $property->setMinimum(15)->shouldBeCalled();
        $property->setMaximum(null)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param Symfony\Component\Validator\Constraints\Length $lengthConstraint
     */
    function it_should_set_maximum_if_property_as_a_length_constraint_with_a_max_attribute($classMetadataFactory, $classMetadata, $propertyMetadata, $property, $lengthConstraint)
    {
        $propertyMetadata->constraints = [$lengthConstraint];
        $lengthConstraint->max         = 42;

        $property->setMinimum(null)->shouldBeCalled();
        $property->setMaximum(42)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param \Symfony\Component\Validator\Constraints\Type $typeNumberConstraint
     * @param \Symfony\Component\Validator\Constraints\Type $typeStringConstraint
     */
    function it_adds_type_if_property_as_a_type_constraint_that_is_not_already_added($classMetadataFactory, $classMetadata, $propertyMetadata, $property, $typeNumberConstraint, $typeStringConstraint)
    {
        $propertyMetadata->constraints = [$typeNumberConstraint];
        $typeNumberConstraint->type    = 'number';

        $property->getType()->willReturn(['string']);

        $property->addType('number')->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param \Symfony\Component\Validator\Constraints\Date $constraint
     */
    function it_adds_date_format_if_property_as_a_date_constraint($classMetadataFactory, $classMetadata, $propertyMetadata, $property, $constraint)
    {
        $propertyMetadata->constraints = [$constraint];
        $property->setFormat(Property::FORMAT_DATE)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param \Symfony\Component\Validator\Constraints\DateTime $constraint
     */
    function it_adds_date_time_format_if_property_as_a_datetime_constraint($classMetadataFactory, $classMetadata, $propertyMetadata, $property, $constraint)
    {
        $propertyMetadata->constraints = [$constraint];
        $property->setFormat(Property::FORMAT_DATETIME)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param \Symfony\Component\Validator\Constraints\Time $constraint
     */
    function it_adds_time_format_if_property_as_a_time_constraint($classMetadataFactory, $classMetadata, $propertyMetadata, $property, $constraint)
    {
        $propertyMetadata->constraints = [$constraint];
        $property->setFormat(Property::FORMAT_TIME)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param \Symfony\Component\Validator\Constraints\Email $constraint
     */
    function it_adds_email_format_if_property_as_an_email_constraint($classMetadataFactory, $classMetadata, $propertyMetadata, $property, $constraint)
    {
        $propertyMetadata->constraints = [$constraint];
        $property->setFormat(Property::FORMAT_EMAIL)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param \Symfony\Component\Validator\Constraints\Ip $constraint
     */
    function it_adds_ipv6_format_if_property_as_an_ip_constraint_with_version_6($classMetadataFactory, $classMetadata, $propertyMetadata, $property, $constraint)
    {
        $propertyMetadata->constraints = [$constraint];
        $constraint->version = '6';
        $property->setFormat(Property::FORMAT_IPV6)->shouldBeCalled();

        $this->handle('some class', $property);
    }

    /**
     * @param \Symfony\Component\Validator\Constraints\Ip $constraint
     */
    function it_adds_ip_address_format_if_property_as_an_ip_constraint_with_version_4($classMetadataFactory, $classMetadata, $propertyMetadata, $property, $constraint)
    {
        $propertyMetadata->constraints = [$constraint];
        $constraint->version = '4';
        $property->setFormat(Property::FORMAT_IPADDRESS)->shouldBeCalled();

        $this->handle('some class', $property);
    }
}
