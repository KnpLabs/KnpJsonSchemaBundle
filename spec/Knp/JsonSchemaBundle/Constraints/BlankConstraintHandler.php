<?php

namespace spec\Knp\JsonSchemaBundle\Constraints;

use PHPSpec2\ObjectBehavior;

class BlankConstraintHandler extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Validator\Constraints\Blank $constraint
     */
    public function let($constraint)
    {
    }

    function it_should_be_initializable()
    {
        $this->shouldBeAnInstanceOf('Knp\JsonSchemaBundle\Constraints\ConstraintHandlerInterface');
    }

    function it_should_support_blank_constraint($constraint)
    {
        $this->supports($constraint)->shouldBe(true);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Property $property
     */
    function it_should_add_blank_constraint_if_property_must_be_blank($property, $constraint)
    {
        $property->setType('null')->shouldBeCalled();
        $this->handle($property, $constraint);
    }

}
