<?php

namespace spec\Knp\JsonSchemaBundle\Model;

use PHPSpec2\ObjectBehavior;

class Property extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('JsonSerializable');
    }

    function it_should_have_a_name()
    {
        $this->setName('a name');
        $this->getName()->shouldBe('a name');
    }

    function it_should_be_non_required_by_default()
    {
        $this->isRequired()->shouldBe(false);
    }

    function it_should_be_required_if_I_say_so()
    {
        $this->setRequired(true);
        $this->isRequired()->shouldBe(true);
    }

    function it_should_not_be_required_if_I_say_so()
    {
        $this->setRequired(true);
        $this->setRequired(false);
        $this->isRequired()->shouldBe(false);
    }

    function it_should_have_a_type()
    {
        $this->setType('the type');
        $this->getType()->shouldBe('the type');
    }

    function it_should_have_a_pattern()
    {
        $this->setPattern('the pattern');
        $this->getPattern()->shouldBe('the pattern');
    }

    function it_should_only_serialize_non_null_properties()
    {
        $this
            ->setType('some type')
        ;
        $this->jsonSerialize()->shouldBe(['required' => false, 'type' => 'some type']);
    }

    /**
     * @param Symfony\Component\Validator\Constraints\NotBlank $constraint
     */
    function it_should_add_required_constraint_if_property_is_not_blank($constraint)
    {
        $this->addConstraint($constraint);
        $this->isRequired()->shouldBe(true);
    }

    /**
     * @param Symfony\Component\Validator\Constraints\Type $constraint
     */
    function it_should_add_type_constraint_if_property_is_typed($constraint)
    {
        $constraint->type = 'text';
        $this->addConstraint($constraint);
        $this->getType()->shouldBe('text');
    }

    /**
     * @param Symfony\Component\Validator\Constraints\Regex $constraint
     */
    function it_should_add_pattern_constraint_if_property_is_regex_validated($constraint)
    {
        $constraint->pattern = '/^[a-z]{3}$/';
        $this->addConstraint($constraint);
        $this->getPattern()->shouldBe('/^[a-z]{3}$/');
    }

    /**
     * @param Symfony\Component\Validator\Constraints\Blank $constraint
     */
    function it_should_add_empty_pattern_constraint_if_property_must_be_blank($constraint)
    {
        $this->addConstraint($constraint);
        $this->getPattern()->shouldBe('/^$/');
    }
}
