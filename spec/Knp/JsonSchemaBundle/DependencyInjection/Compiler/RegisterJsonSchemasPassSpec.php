<?php

namespace spec\Knp\JsonSchemaBundle\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RegisterJsonSchemasPassSpec extends ObjectBehavior
{
    /**
     * @param \Symfony\Component\HttpKernel\Bundle\BundleInterface $bundle
     */
    public function let($bundle)
    {
        $this->beConstructedWith($bundle);
        $bundle->getPath()->willReturn('bundle path');
        $bundle->getNamespace()->willReturn('bundle namespace');
    }

    function it_is_a_compiler_pass()
    {
        $this->shouldHaveType('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    function it_does_nothing_if_schema_registry_is_unavailable(
        $container
    )
    {
        $container->hasDefinition('json_schema.registry')->willReturn(false);
        $container->has('json_schema.reflection_factory')->willReturn(true);
        $container->has('annotation_reader')->willReturn(true);

        $container->getDefinition('json_schema.registry')->shouldNotBeCalled();

        $this->process($container);
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    function it_does_nothing_if_reflection_factory_is_unavailable(
        $container
    )
    {
        $container->hasDefinition('json_schema.registry')->willReturn(true);
        $container->has('json_schema.reflection_factory')->willReturn(false);
        $container->has('annotation_reader')->willReturn(true);

        $container->getDefinition('json_schema.registry')->shouldNotBeCalled();

        $this->process($container);
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    function it_does_nothing_if_annotation_reader_is_unavailable(
        $container
    )
    {
        $container->hasDefinition('json_schema.registry')->willReturn(true);
        $container->has('json_schema.reflection_factory')->willReturn(true);
        $container->has('annotation_reader')->willReturn(false);

        $container->getDefinition('json_schema.registry')->shouldNotBeCalled();

        $this->process($container);
    }

    /**
     * @param \Knp\JsonSchemaBundle\Annotations\Schema                $schema
     * @param \ReflectionClass                                        $refClass
     * @param \Doctrine\Common\Annotations\Reader                     $reader
     * @param \Symfony\Component\DependencyInjection\Definition       $registry
     * @param \Knp\JsonSchemaBundle\Reflection\ReflectionFactory          $factory
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    function it_uses_Schema_annotation_data_to_register_the_class_in_the_schema_registry(
        $reader, $registry, $factory, $container, $schema, $refClass
    )
    {
        $container->hasDefinition(Argument::any())->willReturn(true);
        $container->getDefinition('json_schema.registry')->willReturn($registry);
        $container->has('annotation_reader')->willReturn(true);
        $container->get('annotation_reader')->willReturn($reader);
        $container->has("json_schema.reflection_factory")->willReturn(true);
        $container->get('json_schema.reflection_factory')->willReturn($factory);

        $factory->createFromDirectory(Argument::any(), Argument::any())->willReturn(array($refClass));

        $schema->name = 'foo';
        $reader->getClassAnnotations($refClass)->willReturn(array($schema));

        $refClass->getName()->willReturn('App\\Entity\\Bar');

        $registry->addMethodCall('register', array('foo', 'App\\Entity\\Bar'))->shouldBeCalled();

        $this->process($container);
    }

    /**
     * @param \Knp\JsonSchemaBundle\Annotations\Schema                $schema
     * @param \Doctrine\Common\Annotations\Reader                     $reader
     * @param \Symfony\Component\DependencyInjection\Definition       $registry
     * @param \Knp\JsonSchemaBundle\Reflection\ReflectionFactory          $factory
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    function it_uses_short_class_name_as_alias_if_annotation_name_is_not_set(
        $reader, $registry, $factory, $container, $schema
    )
    {
        $refClass = new \ReflectionClass('\Knp\JsonSchemaBundle\Model\Property');

        $container->hasDefinition(Argument::any())->willReturn(true);
        $container->getDefinition('json_schema.registry')->willReturn($registry);
        $container->has('annotation_reader')->willReturn(true);
        $container->get('annotation_reader')->willReturn($reader);
        $container->has('json_schema.reflection_factory')->willReturn(true);
        $container->get('json_schema.reflection_factory')->willReturn($factory);
        $factory->createFromDirectory(Argument::any(), Argument::any())->willReturn(array($refClass));

        $schema->name = null;
        $reader->getClassAnnotations($refClass)->willReturn(array($schema));

        $registry->addMethodCall('register', array('property', 'Knp\JsonSchemaBundle\Model\Property'))->shouldBeCalled();

        $this->process($container);
    }
}
