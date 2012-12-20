<?php

namespace spec\Knp\JsonSchemaBundle\DependencyInjection\Compiler;

use PHPSpec2\ObjectBehavior;

class RegisterJsonSchemaCompilerPass extends ObjectBehavior
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

    function it_should_be_initializable()
    {
        $this->shouldHaveType('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
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
        $container->has('json_schema.registry')->willReturn(true);
        $container->getDefinition('json_schema.registry')->willReturn($registry);
        $container->get('doctrine.annotations.cached_reader')->willReturn($reader);
        $container->get('json_schema.registry')->willReturn($registry);
        $container->get('json_schema.reflection_factory')->willReturn($factory);

        $factory->createFromDirectory(ANY_ARGUMENTS)->willReturn([$refClass]);

        $schema->name = 'foo';
        $reader->getClassAnnotations($refClass)->willReturn([$schema]);

        $refClass->getName()->willReturn('App\\Entity\\Foo');

        $registry->addMethodCall('register', ['foo', 'App\\Entity\\Foo'])->shouldBeCalled();

        $this->process($container);
    }
}
