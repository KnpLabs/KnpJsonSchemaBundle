<?php

namespace spec\Knp\JsonSchemaBundle\Schema;

use PHPSpec2\ObjectBehavior;

class SchemaGenerator extends ObjectBehavior
{
    /**
     * @param JsonSchema\Validator                          $jsonValidator
     * @param Knp\JsonSchemaBundle\Schema\SchemaBuilder     $schemaBuilder
     * @param Knp\JsonSchemaBundle\Schema\ReflectionFactory $reflectionFactory
     * @param Knp\JsonSchemaBundle\Schema\SchemaRepository  $schemaRepository
     */
    function let($jsonValidator, $schemaBuilder, $reflectionFactory, $schemaRepository)
    {
        $this->beConstructedWith($jsonValidator, $schemaBuilder, $reflectionFactory, $schemaRepository);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Schema $schema
     * @param \ReflectionClass                  $refClass
     */
    function it_should_generate_a_valid_json_schema_with_required_properties(
        $classMetadataFactory, $jsonValidator, $schemaBuilder, $schemaRepository, $schema, $reflectionFactory, $refClass
    )
    {
        $jsonValidator->isValid()->willReturn(true);
        $schemaBuilder->getSchema()->willReturn($schema);
        $schemaRepository->getSchema(ANY_ARGUMENT)->willReturn('some class namespace');

        $reflectionFactory->create('some class namespace')->shouldBeCalled()->willReturn($refClass);
        $refClass->getShortName()->willReturn('User');

        $this->generate('foo')->shouldBe($schema);
    }
}
