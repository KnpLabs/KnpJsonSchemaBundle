<?php

namespace spec\Knp\JsonSchemaBundle\Model;

use PhpSpec\ObjectBehavior;

class PropertySpec extends ObjectBehavior
{
    function it_has_a_write_once_name_property()
    {
        $this->setName('a name');
        $this->setName('another name');
        $this->getName()->shouldBe('a name');
    }

    function it_is_a_non_required_by_default()
    {
        $this->isRequired()->shouldBe(false);
    }

    function it_has_a_write_once_required_property()
    {
        $this->setRequired(true);
        $this->setRequired(false);
        $this->isRequired()->shouldBe(true);
    }

    function it_is_not_be_required_if_I_say_so()
    {
        $this->setRequired(false);
        $this->isRequired()->shouldBe(false);
    }

    function it_has_a_type_property()
    {
        $this->addType('the type');
        $this->addType('another type');
        $this->getType()->shouldBe(array('the type', 'another type'));
    }

    function its_addType_will_not_add_type_if_it_already_has_it()
    {
        $this->addType('the type');
        $this->addType('the type');
        $this->getType()->shouldBe(array('the type'));
    }

    function it_has_a_write_once_pattern_property()
    {
        $this->setPattern('the pattern');
        $this->setPattern('another pattern');
        $this->getPattern()->shouldBe('the pattern');
    }

    function it_has_a_write_once_enumeration_property()
    {
        $this->setEnumeration(array('foo', 'bar', 'baz'));
        $this->setEnumeration(array('a', 'lo', 'ha'));
        $this->getEnumeration()->shouldBe(array('foo', 'bar', 'baz'));
    }

    function it_has_a_write_once_minimum_property()
    {
        $this->setMinimum(2);
        $this->setMinimum(5);
        $this->getMinimum()->shouldBe(5);
    }

    function it_has_a_write_once_maximum_property()
    {
        $this->setMaximum(5);
        $this->setMaximum(2);
        $this->getMaximum()->shouldBe(2);
    }

    function it_has_a_write_once_exclusiveMinimum_property()
    {
        $this->setExclusiveMinimum(true);
        $this->setExclusiveMinimum(false);
        $this->isExclusiveMinimum()->shouldBe(true);
    }

    function it_has_a_write_once_exclusiveMaximum_property()
    {
        $this->setExclusiveMaximum(true);
        $this->setExclusiveMaximum(false);
        $this->isExclusiveMaximum()->shouldBe(true);
    }

    function it_has_a_write_once_format_property()
    {
        $this->setFormat('date-time');
        $this->setFormat('date');
        $this->getFormat()->shouldBe('date-time');
    }

    function it_has_a_write_once_disallowed_property()
    {
        $this->setDisallowed(array('boolean', 'string'));
        $this->setDisallowed(array('number'));
        $this->getDisallowed()->shouldBe(array('boolean', 'string'));
    }

    function it_serializes_type_as_a_string_if_it_has_single_value()
    {
        $this->addType('a type');
        $this->jsonSerialize()->shouldBe(array('type' => 'a type'));
    }

    function it_serializes_type_as_an_array_if_it_has_multiple_values()
    {
        $this->addType('a type');
        $this->addType('another type');
        $this->jsonSerialize()->shouldBe(array('type' => array('a type', 'another type')));
    }

    function it_only_serializes_non_null_properties()
    {
        $this->jsonSerialize()->shouldBe(array());
    }

    function it_serializse_enumeration_if_there_is_one()
    {
        $this->setEnumeration(array('a','simple','list','of','choice'));
        $this->jsonSerialize()->shouldBe(array('enum' => array('a','simple','list','of','choice')));
    }

    function it_serializes_minimum_maximum_and_exclusive_constraints_if_type_is_number()
    {
        $this
            ->addType('number')
            ->setMinimum(10)
            ->setMaximum(15)
        ;
        $this->jsonSerialize()->shouldBe(array(
            'type'             => 'number',
            'minimum'          => 10,
            'exclusiveMinimum' => false,
            'maximum'          => 15,
            'exclusiveMaximum' => false,
        ));
    }

    function it_serializes_minimum_maximum_exclusive_constraints_if_type_is_integer()
    {
        $this
            ->addType('integer')
            ->setMinimum(10)
            ->setMaximum(15)
        ;
        $this->jsonSerialize()->shouldBe(array(
            'type'             => 'integer',
            'minimum'          => 10,
            'exclusiveMinimum' => false,
            'maximum'          => 15,
            'exclusiveMaximum' => false,
        ));
    }

    function it_serializes_minLength_and_maxLength_if_type_is_string()
    {
        $this
            ->addType('string')
            ->setMinimum(10)
            ->setMaximum(15)
        ;
        $this->jsonSerialize()->shouldBe(array(
            'type'      => 'string',
            'minLength' => 10,
            'maxLength' => 15,
        ));
    }

    function it_serializes_disallow_as_array_if_it_has_been_defined()
    {
        $this->setDisallowed(array("boolean", "number", array("type" => "string", "format" => "email")));

        $this->jsonSerialize()->shouldBe(array(
            'disallow' => array(
                'boolean',
                'number',
                array('type' => 'string', 'format' => 'email'),
            ),
        ));
    }
}
