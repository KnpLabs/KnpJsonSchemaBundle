<?php

namespace spec\Knp\JsonSchemaBundle\DependencyInjection\Compiler;

use PHPSpec2\ObjectBehavior;

class RegisterJsonSchemasPass extends ObjectBehavior
{
    /**
     * @param Symfony\Component\HttpKernel\Bundle\BundleInterface $bundle
     */
    public function let($bundle)
    {
        $this->beConstructedWith($bundle);
        $bundle->getPath()->willReturn('bundle path');
        $bundle->getNamespace()->willReturn('bundle namespace');
    }

    function it_should_be_a_compiler_pass()
    {
        $this->shouldHaveType('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    /**
     * @param Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    function it_should_do_nothing_if_schema_registry_is_unavailable(
        $container
    )
    {
        $container->hasDefinition('json_schema.registry')->willReturn(false);
        $container->has('json_schema.reflection_factory')->willReturn(true);
        $container->has('doctrine.annotations.cached_reader')->willReturn(true);

        $container->getDefinition('json_schema.registry')->shouldNotBeCalled();

        $this->process($container);
    }

    /**
     * @param Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    function it_should_do_nothing_if_reflection_factory_is_unavailable(
        $container
    )
    {
        $container->hasDefinition('json_schema.registry')->willReturn(true);
        $container->has('json_schema.reflection_factory')->willReturn(false);
        $container->has('doctrine.annotations.cached_reader')->willReturn(true);

        $container->getDefinition('json_schema.registry')->shouldNotBeCalled();

        $this->process($container);
    }

    /**
     * @param Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    function it_should_do_nothing_if_annotation_reader_is_unavailable(
        $container
    )
    {
        $container->hasDefinition('json_schema.registry')->willReturn(true);
        $container->has('json_schema.reflection_factory')->willReturn(true);
        $container->has('doctrine.annotations.cached_reader')->willReturn(false);

        $container->getDefinition('json_schema.registry')->shouldNotBeCalled();

        $this->process($container);
    }

    /**
     * @param Knp\JsonSchemaBundle\Annotations\Schema                $schema
     * @param ReflectionClass                                        $refClass
     * @param Doctrine\Common\Annotations\Reader                     $reader
     * @param Symfony\Component\DependencyInjection\Definition       $registry
     * @param Knp\JsonSchemaBundle\Schema\ReflectionFactory          $factory
     * @param Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    function it_should_use_Schema_annotation_data_to_register_the_class_in_the_schema_registry(
        $reader, $registry, $factory, $container, $schema, $refClass
    )
    {
        $container->hasDefinition(ANY_ARGUMENT)->willReturn(true);
        $container->getDefinition('json_schema.registry')->willReturn($registry);
        $container->get('doctrine.annotations.cached_reader')->willReturn($reader);
        $container->get('json_schema.reflection_factory')->willReturn($factory);

        $factory->createFromDirectory(ANY_ARGUMENTS)->willReturn([$refClass]);

        $schema->name = 'foo';
        $reader->getClassAnnotations($refClass)->willReturn([$schema]);

        $refClass->getName()->willReturn('App\\Entity\\Bar');

        $registry->addMethodCall('register', ['foo', 'App\\Entity\\Bar'])->shouldBeCalled();

        $this->process($container);
    }

    /**
     * @param Knp\JsonSchemaBundle\Annotations\Schema                $schema
     * @param ReflectionClass                                        $refClass
     * @param Doctrine\Common\Annotations\Reader                     $reader
     * @param Symfony\Component\DependencyInjection\Definition       $registry
     * @param Knp\JsonSchemaBundle\Schema\ReflectionFactory          $factory
     * @param Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    function it_should_use_short_class_name_as_alias_if_annotation_name_is_not_set(
        $reader, $registry, $factory, $container, $schema, $refClass
    )
    {
        $container->hasDefinition(ANY_ARGUMENT)->willReturn(true);
        $container->getDefinition('json_schema.registry')->willReturn($registry);
        $container->get('doctrine.annotations.cached_reader')->willReturn($reader);
        $container->get('json_schema.reflection_factory')->willReturn($factory);
        $factory->createFromDirectory(ANY_ARGUMENTS)->willReturn([$refClass]);

        $schema->name = null;
        $reader->getClassAnnotations($refClass)->willReturn([$schema]);

        $refClass->getName()->willReturn('App\\Entity\\Foo');
        $refClass->getShortName()->willReturn('Foo');

        $registry->addMethodCall('register', ['foo', 'App\\Entity\\Foo'])->shouldBeCalled();

        $this->process($container);
    }
}
