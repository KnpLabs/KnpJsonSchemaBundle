<?php

namespace spec\Knp\JsonSchemaBundle\Model;

use PHPSpec2\ObjectBehavior;

class Property extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('JsonSerializable');
    }

    function it_should_have_a_write_once_name_property()
    {
        $this->setName('a name');
        $this->setName('another name');
        $this->getName()->shouldBe('a name');
    }

    function it_should_be_non_required_by_default()
    {
        $this->isRequired()->shouldBe(false);
    }

    function it_should_have_a_write_once_required_property()
    {
        $this->setRequired(true);
        $this->setRequired(false);
        $this->isRequired()->shouldBe(true);
    }

    function it_should_not_be_required_if_I_say_so()
    {
        $this->setRequired(false);
        $this->isRequired()->shouldBe(false);
    }

    function it_should_have_a_write_once_type_property()
    {
        $this->setType('the type');
        $this->setType('another type');
        $this->getType()->shouldBe('the type');
    }

    function it_should_have_a_write_once_pattern_property()
    {
        $this->setPattern('the pattern');
        $this->setPattern('another pattern');
        $this->getPattern()->shouldBe('the pattern');
    }

    function it_should_have_a_write_once_enumeration_property()
    {
        $this->setEnumeration(['foo', 'bar', 'baz']);
        $this->setEnumeration(['a', 'lo', 'ha']);
        $this->getEnumeration()->shouldBe(['foo', 'bar', 'baz']);
    }

    function it_should_have_a_write_once_minimum_property()
    {
        $this->setMinimum(2);
        $this->setMinimum(5);
        $this->getMinimum()->shouldBe(2);
    }

    function it_should_have_a_write_once_maximum_property()
    {
        $this->setMaximum(5);
        $this->setMaximum(2);
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
