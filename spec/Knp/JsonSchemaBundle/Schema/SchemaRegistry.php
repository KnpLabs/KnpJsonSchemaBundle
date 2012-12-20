<?php

namespace spec\Knp\JsonSchemaBundle\Schema;

use PHPSpec2\ObjectBehavior;

class SchemaRegistry extends ObjectBehavior
{
    function it_should_register_a_new_classname_with_its_alias_to_its_repository()
    {
        $this->register('foo', 'App\\Entity\\Foo');
        $this->all()->shouldHaveCount(1);
    }

    function it_should_get_a_classname_from_its_alias()
    {
        $this->register('foo', 'App\\Entity\\Foo');
        $this->get('foo')->shouldReturn('App\\Entity\\Foo');
    }

    function its_register_should_throw_exception_if_the_alias_is_already_registered()
    {
        $this->register('foo', 'App\\Entity\\Foo');
        $this->shouldThrow(new \Exception('Alias "foo" is already used for schema "App\\Entity\\Foo".'))->duringRegister('foo', 'App\\Model\\Foo');
    }

    function its_getSchema_should_throw_exception_if_the_alias_does_not_exist()
    {
        $this->shouldThrow(new \Exception('Alias "bar" is not registered.'))->duringGet('bar');
    }
}
