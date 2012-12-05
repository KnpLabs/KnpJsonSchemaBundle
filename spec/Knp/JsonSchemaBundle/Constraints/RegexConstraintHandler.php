<?php

namespace spec\Knp\JsonSchemaBundle\Constraints;

use PHPSpec2\ObjectBehavior;

class RegexConstraintHandler extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Validator\Constraints\Regex $constraint
     */
    public function let($constraint)
    {
    }

    function it_should_be_initializable()
    {
        $this->shouldBeAnInstanceOf('Knp\JsonSchemaBundle\Constraints\ConstraintHandlerInterface');
    }

    function it_should_support_regex_constraint($constraint)
    {
        $this->supports($constraint)->shouldBe(true);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Property $property
     */
    function it_should_add_pattern_constraint_if_property_must_match_a_pattern($property, $constraint)
    {
        $constraint->pattern = '/^[a-z]{3}$/';
        $property->setPattern('/^[a-z]{3}$/')->shouldBeCalled();
        $this->handle($property, $constraint);
    }
}
