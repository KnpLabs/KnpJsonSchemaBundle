<?php

namespace spec\Knp\JsonSchemaBundle\Constraints;

use PHPSpec2\ObjectBehavior;

class TypeConstraintHandler extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Validator\Constraints\Type $constraint
     */
    public function let($constraint)
    {
    }

    function it_should_be_initializable()
    {
        $this->shouldBeAnInstanceOf('Knp\JsonSchemaBundle\Constraints\ConstraintHandlerInterface');
    }

    function it_should_support_type_constraint($constraint)
    {
        $this->supports($constraint)->shouldBe(true);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Property $property
     */
    function it_should_add_type_string_constraint_if_property_is_typed_as_text($property, $constraint)
    {
        $constraint->type = 'text';
        $property->setType('string')->shouldBeCalled();

        $this->handle($property, $constraint);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Property $property
     */
    function it_should_add_type_number_constraint_if_property_is_typed_as_float($property, $constraint)
    {
        $constraint->type = 'float';
        $property->setType('number')->shouldBeCalled();

        $this->handle($property, $constraint);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Property $property
     */
    function it_should_add_type_integer_constraint_if_property_is_typed_as_integer($property, $constraint)
    {
        $constraint->type = 'integer';
        $property->setType('integer')->shouldBeCalled();

        $this->handle($property, $constraint);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Property $property
     */
    function it_should_add_type_boolean_constraint_if_property_is_typed_as_boolean($property, $constraint)
    {
        $constraint->type = 'boolean';
        $property->setType('boolean')->shouldBeCalled();

        $this->handle($property, $constraint);
    }
}
