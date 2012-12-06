<?php

namespace spec\Knp\JsonSchemaBundle\Schema;

use PHPSpec2\ObjectBehavior;

class SchemaGenerator extends ObjectBehavior
{
    /**
     * @param JsonSchema\Validator $jsonValidator
     * @param Knp\JsonSchemaBundle\Schema\SchemaBuilder $schemaBuilder
     * @param Knp\JsonSchemaBundle\Schema\ReflectionFactory $reflectionFactory
     */
    function let($jsonValidator, $schemaBuilder, $reflectionFactory)
    {
        $this->beConstructedWith($jsonValidator, $schemaBuilder, $reflectionFactory);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Schema $schema
     * @param \ReflectionClass $refClass
     */
    function it_should_generate_a_valid_json_schema_with_required_properties($classMetadataFactory, $jsonValidator, $schemaBuilder, $schema, $reflectionFactory, $refClass)
    {
        $jsonValidator->isValid()->willReturn(true);
        $schemaBuilder->getSchema()->willReturn($schema);

        $reflectionFactory->create('App\\Entity\\User')->willReturn($refClass);
        $refClass->getShortName()->willReturn('User');

        $this->generate('App\\Entity\\User')->shouldBe($schema);
    }
}
