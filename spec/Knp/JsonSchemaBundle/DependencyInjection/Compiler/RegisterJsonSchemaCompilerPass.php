<?php

namespace spec\Knp\JsonSchemaBundle\DependencyInjection\Compiler;

use PHPSpec2\ObjectBehavior;

class RegisterJsonSchemaCompilerPass extends ObjectBehavior
{
    /**
     * @param Doctrine\Common\Annotations\Reader                     $reader
     * @param Knp/JsonSchemaBundle/Schema/SchemaRepository           $schemaRepository
     * @param Knp/JsonSchemaBundle/Schema/ReflectionFactory          $reflectionFactory
     * @param Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    function let($reader, $schemaRepository, $reflectionFactory, $container)
    {
        $this->beConstructedWith($reader, $schemaRepository, $reflectionFactory);
    }

    function it_should_be_initializable()
    {
        $this->shouldHaveType('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    /**
     * @param Knp\JsonSchemaBundle\Annotations\Schema $schema
     * @param ReflectionClass                         $refClass
     */
    function it_should_use_Schema_annotation_data_to_register_the_class_in_the_schema_repository(
        $reader, $schemaRepository, $reflectionFactory, $container, $schema, $refClass
    )
    {
        $container->has('json_schema.repository')->willReturn(true);
        $container->get('json_schema.repository')->willReturn($schemaRepository);

        /** It should look by default into Entity and Model directories, but should be configurable */
        $reflectionFactory->createFromRepository(ANY_ARGUMENT)->willReturn([$refClass]);

        $schema->name = 'foo';
        $reader->getClassAnnotations($refClass)->willReturn([$schema]);

        $refClass->getName()->willReturn('App\\Entity\\Foo');

        $schemaRepository->add('foo', 'App\\Entity\\Foo')->shouldBeCalled();

        $this->process($container);
    }
}
