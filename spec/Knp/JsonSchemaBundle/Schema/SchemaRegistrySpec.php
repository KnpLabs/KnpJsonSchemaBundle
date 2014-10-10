<?php

namespace spec\Knp\JsonSchemaBundle\Schema;

use PhpSpec\ObjectBehavior;

class SchemaRegistrySpec extends ObjectBehavior
{
    function it_registers_a_new_namespace_with_its_alias_to_its_repository()
    {
        $this->register('foo', 'App\\Entity\\Foo');
        $this->all()->shouldHaveCount(1);
    }

    function it_gets_a_namespace_from_its_alias()
    {
        $this->register('foo', 'App\\Entity\\Foo');
        $this->getNamespace('foo')->shouldReturn('App\\Entity\\Foo');
    }

    function its_throws_exception_if_the_alias_is_already_registered()
    {
        $this->register('foo', 'App\\Entity\\Foo');
        $e = new \Exception('Alias "foo" is already used for namespace "App\\Entity\\Foo".');
        $this->shouldThrow($e)->duringRegister('foo', 'App\\Model\\Bar');
    }

    function its_throws_exception_if_the_namespace_is_already_registered()
    {
        $this->register('bar', 'App\\Entity\\Foo');
        $e = new \Exception('Namespace "App\\Entity\\Foo" is already registered with alias "bar".');
        $this->shouldThrow($e)->duringRegister('foo', 'App\\Entity\\Foo');
    }

    function its_getNamespace_throws_exception_if_the_alias_does_not_exist()
    {
        $this->shouldThrow(new \Exception('Alias "bar" is not registered.'))->duringGetNamespace('bar');
    }

    function it_get_alias_for_a_specified_namespace()
    {
        $this->register('foo', 'App\\Entity\\Foo');

        $this->getAlias('App\\Entity\\Foo')->shouldReturn('foo');
    }

    function its_getAlias_throws_exception_if_the_namespace_does_not_exist()
    {
        $this->shouldThrow(new \Exception('Namespace "App\\Entity\\Foo" is not registered.'))->duringGetAlias('App\\Entity\\Foo');
    }

    function its_getAliases_returns_only_registered_aliases()
    {
        $this->register('foo', 'App\\Entity\\Foo');
        $this->register('bar', 'App\\Entity\\Bar');

        $this->getAliases()->shouldReturn(array('foo', 'bar'));
    }
}
