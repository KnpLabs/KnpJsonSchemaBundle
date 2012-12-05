<?php

namespace spec\Knp\JsonSchemaBundle\Constraints;

use PHPSpec2\ObjectBehavior;

class NotBlankConstraintHandler extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Validator\Constraints\NotBlank $constraint
     */
    public function let($constraint)
    {
    }

    function it_should_be_initializable()
    {
        $this->shouldBeAnInstanceOf('Knp\JsonSchemaBundle\Constraints\ConstraintHandlerInterface');
    }

    function it_should_support_not_blank_constraint($constraint)
    {
        $this->supports($constraint)->shouldBe(true);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Property $property
     */
    function it_should_add_required_constraint_if_property_is_not_blank($property, $constraint)
    {
        $property->setRequired(true)->shouldBeCalled();
        $this->handle($property, $constraint);
    }
}
