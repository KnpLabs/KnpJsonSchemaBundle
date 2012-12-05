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

    function it_should_only_serialize_non_null_properties()
    {
        $this
            ->setType('some type')
        ;
        $this->jsonSerialize()->shouldBe(['required' => false, 'type' => 'some type']);
    }

    function it_should_serialize_enumeration_if_there_is_one()
    {
        $this
            ->setEnumeration(['a','simple','list','of','choice'])
        ;
        $this->jsonSerialize()->shouldBe(['required' => false, 'enum' => ['a','simple','list','of','choice']]);
    }
}
