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

    function it_should_have_an_enumeration()
    {
        $this->setEnumeration(['foo', 'bar', 'baz']);
        $this->getEnumeration()->shouldBe(['foo', 'bar', 'baz']);
    }

    function it_should_have_a_minimum()
    {
        $this->setMinimum(2);
        $this->getMinimum()->shouldBe(2);
    }

    function it_should_have_a_maximum()
    {
        $this->setMaximum(5);
        $this->getMaximum()->shouldBe(5);
    }

    function it_should_only_serialize_non_null_properties()
    {
        $this->setType('some type');
        $this->jsonSerialize()->shouldBe(['required' => false, 'type' => 'some type']);
    }

    function it_should_serialize_enumeration_if_there_is_one()
    {
        $this->setEnumeration(['a','simple','list','of','choice']);
        $this->jsonSerialize()->shouldBe(['required' => false, 'enum' => ['a','simple','list','of','choice']]);
    }

    function it_should_serialize_minimum_and_maximum_if_type_is_number()
    {
        $this
            ->setType('number')
            ->setMinimum(10)
            ->setMaximum(15)
        ;
        $this->jsonSerialize()->shouldBe([
            'required' => false,
            'type'     => 'number',
            'minimum'  => 10,
            'maximum'  => 15,
        ]);
    }

    function it_should_serialize_minimum_and_maximum_if_type_is_integer()
    {
        $this
            ->setType('integer')
            ->setMinimum(10)
            ->setMaximum(15)
        ;
        $this->jsonSerialize()->shouldBe([
            'required' => false,
            'type'     => 'integer',
            'minimum'  => 10,
            'maximum'  => 15,
        ]);
    }

    function it_should_serialize_minLength_and_maxLength_if_type_is_string()
    {
        $this
            ->setType('string')
            ->setMinimum(10)
            ->setMaximum(15)
        ;
        $this->jsonSerialize()->shouldBe([
            'required'  => false,
            'type'      => 'string',
            'minLength' => 10,
            'maxLength' => 15,
        ]);
    }
}
