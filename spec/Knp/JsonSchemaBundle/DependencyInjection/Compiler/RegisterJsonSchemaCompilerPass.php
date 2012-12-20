<?php

namespace spec\Knp\JsonSchemaBundle\DependencyInjection\Compiler;

use PHPSpec2\ObjectBehavior;

class RegisterJsonSchemaCompilerPass extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    /**
     * @param Knp\JsonSchemaBundle\Annotations\Schema       $schema
     * @param ReflectionClass                               $refClass
     * @param Doctrine\Common\Annotations\Reader            $reader
     * @param Knp\JsonSchemaBundle\Schema\SchemaRegistry    $registry
     * @param Knp\JsonSchemaBundle\Schema\ReflectionFactory $factory
     */
    function it_should_use_Schema_annotation_data_to_register_the_class_in_the_schema_registry(
        $reader, $registry, $factory, $container, $schema, $refClass
    )
    {
        $container->has('json_schema.registry')->willReturn(true);
        $container->get('json_schema.registry')->willReturn($schemaRegistry);
        $container->get('doctrine.annotations.cached_reader')->willReturn($reader);
        $container->get('json_schema.registry')->willReturn($registry);
        $container->get('json_schema.reflection_factory')->willReturn($factory);

        $reflectionFactory->createFromDirectory(ANY_ARGUMENT)->willReturn([$refClass]);

        $schema->name = 'foo';
        $reader->getClassAnnotations($refClass)->willReturn([$schema]);

        $refClass->getName()->willReturn('App\\Entity\\Foo');

        $schemaRegistry->add('foo', 'App\\Entity\\Foo')->shouldBeCalled();

        $this->process($container);
    }
}
