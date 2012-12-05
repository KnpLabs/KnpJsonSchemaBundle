<?php

namespace spec\Knp\JsonSchemaBundle\Constraints;

use PHPSpec2\ObjectBehavior;

class ChoiceConstraintHandler extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Validator\Constraints\Choice $constraint
     */
    public function let($constraint)
    {
    }

    function it_should_be_initializable()
    {
        $this->shouldBeAnInstanceOf('Knp\JsonSchemaBundle\Constraints\ConstraintHandlerInterface');
    }

    function it_should_support_choice_constraint($constraint)
    {
        $this->supports($constraint)->shouldBe(true);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Property $property
     */
    function it_should_add_enumeration_constraint_if_property_must_be_within_a_set_of_choices($property, $constraint)
    {
        $constraint->choices = ['foo', 'bar', 'fu fuz'];
        $property->setEnumeration(['foo', 'bar', 'fu fuz'])->shouldBeCalled();

        $this->handle($property, $constraint);
    }
}
